<?php

if ($id = $_REQUEST['id']) {
    $movie = Movie::get($id);

    if (!$movie) {
        abort(404);
    }

    $reviews = $database
        ->query(
            "SELECT 
                reviews.*,
                users.name || ' ' || users.surname as user_name,
                -- users.image as user_image,
                COUNT(user_reviews.id) as user_review_count
            FROM reviews 
            LEFT JOIN users ON reviews.user_id = users.id
            LEFT JOIN reviews as user_reviews ON reviews.user_id = user_reviews.user_id
            WHERE reviews.movie_id = :movie_id
            GROUP BY reviews.id",
            ['movie_id' => $id],
            Review::class
        )
        ->fetchAll();
} else {
    abort(404);
}

view('movie', compact('movie', 'reviews'));
