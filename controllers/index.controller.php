<?php

$search = $_GET['search'] ?? '';

$movies = $database->query(
    'SELECT * FROM movies WHERE (title LIKE :search OR genre LIKE :search)',
    ['search' => "%{$search}%"],
    Movie::class
)
    ->fetchAll();

view('index', compact('movies'));
