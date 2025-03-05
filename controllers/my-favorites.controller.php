<?php

if (!auth()) {
    redirectBack();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = Validator::validate([
        'movie_id' => ['exists:movies,id'],
        'action' => ['required', 'in:add,remove'],
    ], $_POST, [
        'movie_id' => 'Movie',
        'action' => 'Action',
    ]);

    if (!$validator->isValid()) {
        Session::flash('errors', $validator->getErrors());
        Session::flash('old', $_POST);

        Session::flash('message::error', 'Please check your form for errors');

        redirectBack();
    }

    $movieId = $_POST['movie_id'];
    $action = $_POST['action'];

    if ($action === 'add') {
        $database->query(
            'INSERT INTO user_movies (user_id, movie_id) VALUES (:user_id, :movie_id)',
            ['user_id' => auth()->id, 'movie_id' => $movieId]
        );

        $name = $database->query('SELECT title FROM movies WHERE id = :id', ['id' => $movieId])->fetch()->title;

        Session::flash('message::success', "Movie {$name} as been added to your favorites");
    } else {
        $database->query(
            'DELETE FROM user_movies WHERE user_id = :user_id AND movie_id = :movie_id',
            ['user_id' => auth()->id, 'movie_id' => $movieId]
        );

        $name = $database->query('SELECT title FROM movies WHERE id = :id', ['id' => $movieId])->fetch()->title;

        Session::flash('message::success', "Movie {$name} as been removed from your favorites");
    }

    redirectBack();
}

$search = $_GET['search'] ?? '';

$movies = $database->query(
    'SELECT 
        movies.*,
        CASE WHEN user_movies.id IS NULL THEN 0 ELSE 1 END AS is_my_movie
    FROM movies 
    INNER JOIN user_movies ON user_movies.movie_id = movies.id AND user_movies.user_id = :user_id 
    WHERE (movies.title LIKE :search OR movies.genre LIKE :search)
    ORDER BY movies.title ASC',
    ['search' => "%{$search}%", 'user_id' => auth()->id],
    Movie::class
)
    ->fetchAll();

view('my-favorites', compact('movies', 'search'));
