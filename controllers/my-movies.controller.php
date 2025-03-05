<?php

if (!auth()) {
    redirectBack();
}

$search = $_GET['search'] ?? '';

$movies = $database->query(
    'SELECT 
        movies.*
    FROM movies 
    WHERE (movies.title LIKE :search OR movies.genre LIKE :search) AND movies.user_id = :user_id
    ORDER BY movies.title ASC',
    ['search' => "%{$search}%", 'user_id' => auth()->id],
    Movie::class
)
    ->fetchAll();

view('my-movies', [
    'movies' => $movies,
    'search' => $search,
    'form_control' => true,
]);
