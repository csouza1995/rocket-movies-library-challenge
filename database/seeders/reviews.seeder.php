<?php

$users = $database->query('SELECT * FROM users')->fetchAll();
$movies = $database->query('SELECT * FROM movies')->fetchAll();

foreach ($movies as $movie) {
    foreach ($users as $user) {
        if (rand(0, 1)) {
            continue;
        }

        $database->query(
            'INSERT INTO reviews (user_id, movie_id, rating, description) VALUES (:user_id, :movie_id, :rating, :description)',
            [
                'user_id' => $user->id,
                'movie_id' => $movie->id,
                'rating' => rand(2, 5),
                'description' => 'This is a review for ' . $movie->title,
            ]
        );
    }

    $movieRating = $database
        ->query(
            'SELECT AVG(rating) as rating FROM reviews WHERE movie_id = :movie_id',
            ['movie_id' => $movie->id]
        )
        ->fetch();

    $database->query(
        'UPDATE movies SET rating = :rating WHERE id = :id',
        [
            'id' => $movie->id,
            'rating' => round($movieRating->rating, 1),
        ]
    );
}

echo 'Reviews seeded successfully' . PHP_EOL;
