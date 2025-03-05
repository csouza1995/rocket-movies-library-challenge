<?php

$search = $_GET['search'] ?? '';

$movies = $database->query(
    'SELECT 
        movies.*,
        CASE WHEN user_movies.id IS NULL THEN 0 ELSE 1 END AS is_my_movie
    FROM movies 
    LEFT JOIN user_movies ON user_movies.movie_id = movies.id AND user_movies.user_id = :user_id 
    WHERE (movies.title LIKE :search OR movies.genre LIKE :search)
    ORDER BY movies.title ASC',
    ['search' => "%{$search}%", 'user_id' => auth()->id],
    Movie::class
)
    ->fetchAll();

view('index', compact('movies'));
