<?php

if (!auth() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectBack();
}

$method = $_POST['_method'] ?? 'POST';

if ($method === 'DELETE') {
    $id = $_POST['id'] ?? null;
    $movie_id = $_POST['movie_id'];

    $database->query('DELETE FROM reviews WHERE id = :id', compact('id'));

    // Update the book rating
    $movieRating = $database
        ->query(
            'SELECT AVG(rating) as rating FROM reviews WHERE movie_id = :movie_id',
            ['movie_id' => $movie_id]
        )
        ->fetch();

    $database->query(
        'UPDATE movies SET rating = :rating WHERE id = :id',
        ['rating' => $movieRating->rating, 'id' => $movie_id]
    );

    Session::flash('message::success', 'Review has been deleted');

    redirect('movie?id=' . $movie_id);
}

$validator = Validator::validate([
    'movie_id' => ['required', 'numeric', 'exists:movies,id'],
    'rating' => ['required', 'numeric'],
    'description' => ['required', 'min:3'],
], $_POST, [
    'movie_id' => 'Movie',
    'rating' => 'Rating',
    'description' => 'Description',
]);

if (!$validator->isValid()) {
    Session::flash('errors', $validator->getErrors());
    Session::flash('old', $_POST);

    Session::flash('message::error', 'Please check your form for errors');

    redirect('movie?id=' . $_POST['movie_id'] . '&modal=1');
}

$id = $_POST['id'] ?? null;
$movie_id = $_POST['movie_id'];
$rating = $_POST['rating'];
$description = $_POST['description'];
$user_id = auth()->id;

$review = $database
    ->query(
        'SELECT * FROM reviews WHERE movie_id = :movie_id AND user_id = :user_id',
        compact('movie_id', 'user_id')
    )
    ->fetch();

if ($review) {
    // only one review per user and if has duplicate, update it
    $id = $review->id;
}

if ($id) {
    $database->query(
        'UPDATE reviews SET rating = :rating, description = :description WHERE id = :id',
        compact('rating', 'description', 'id')
    );
} else {
    $database->query(
        'INSERT INTO reviews (user_id, movie_id, rating, description) VALUES (:user_id, :movie_id, :rating, :description)',
        compact('user_id', 'movie_id', 'rating', 'description')
    );
}

// Update the book rating
$movieRating = $database
    ->query(
        'SELECT AVG(rating) as rating FROM reviews WHERE movie_id = :movie_id',
        ['movie_id' => $movie_id]
    )
    ->fetch();

$database->query(
    'UPDATE movies SET rating = :rating WHERE id = :id',
    ['rating' => $movieRating->rating, 'id' => $movie_id]
);

Session::flash('message::success', 'Review has been saved');

redirect('movie?id=' . $movie_id);
