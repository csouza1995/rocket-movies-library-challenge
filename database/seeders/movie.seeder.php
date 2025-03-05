<?php

$sql = file_get_contents('database/seeders/data/movies.seeder.sql');

$database->exec($sql);

$users = $database->query('SELECT * FROM users')->fetchAll();
$movies = $database->query('SELECT * FROM movies')->fetchAll();

foreach ($movies as $movie) {
    $database->query(
        'UPDATE movies SET user_id = :user_id WHERE id = :id',
        [
            'user_id' => $users[array_rand($users)]->id,
            'id' => $movie->id,
        ],
    );
}

echo 'Movies seeded successfully' . PHP_EOL;
