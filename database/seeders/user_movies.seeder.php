<?php

$users = $database->query('SELECT * FROM users')->fetchAll();
$movies = $database->query('SELECT * FROM movies')->fetchAll();

foreach ($users as $user) {
    $moviesOfUser = array_filter($movies, function ($movie) {
        return rand(0, 1);
    });

    foreach ($moviesOfUser as $movie) {
        $database->query(
            'INSERT INTO user_movies (user_id, movie_id) VALUES (:user_id, :movie_id)',
            [
                'user_id' => $user->id,
                'movie_id' => $movie->id,
            ]
        );
    }
}

echo 'Movies seeded successfully' . PHP_EOL;
