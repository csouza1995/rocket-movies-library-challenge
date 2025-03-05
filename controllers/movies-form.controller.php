<?php

if (!auth()) {
    redirectBack();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = Validator::validate([
        'title' => ['required', 'min:3', 'max:255'],
        'genre' => ['required', 'min:3', 'max:255'],
        'year' => ['required', 'numeric', 'min:1900', 'max:' . date('Y') + 2],
        'description' => ['required', 'min:3'],
    ], $_POST, [
        'title' => 'Title',
        'genre' => 'Genre',
        'year' => 'Year',
        'description' => 'Description',
    ]);

    if (!$validator->isValid()) {
        Session::flash('errors', $validator->getErrors());
        Session::flash('old', $_POST);

        Session::flash('message::error', 'Please check your form for errors');

        redirectBack();
    }

    $id = $_POST['id'] ?? null;
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    $poster = null;
    if ($_FILES['poster'] && $_FILES['poster']['name']) {
        $poster = Storage::store($_FILES['poster'], 'images/movies/');
    }

    $movie = $database
        ->query(
            'SELECT * FROM movies WHERE title = :title',
            compact('title')
        )
        ->fetch();

    if ($movie && $movie->id != $id) {
        Session::flash('message::error', 'Movie already exists');
        redirectBack();
    }

    if ($id && !$poster) {
        $movie = $database
            ->query(
                'SELECT * FROM movies WHERE id = :id',
                ['id' => $id]
            )
            ->fetch();

        $poster = $movie->poster ?? 'https://placehold.co/500x400';
    }

    if ($id) {
        $database->query(
            'UPDATE movies SET title = :title, genre = :genre, year = :year, description = :description, poster = :poster WHERE id = :id',
            [
                'id' => $id,
                'title' => $title,
                'genre' => $genre,
                'year' => $year,
                'description' => $description,
                'poster' => $poster,
            ]
        );
    } else {
        $database->query(
            'INSERT INTO movies (title, genre, year, description, poster) VALUES (:title, :genre, :year, :description, :poster)',
            [
                'title' => $title,
                'genre' => $genre,
                'year' => $year,
                'description' => $description,
                'poster' => $poster,
            ]
        );
    }

    Session::flash('message::success', 'Movie saved successfully');
    redirect('my-movies');
}

if ($id = $_REQUEST['id']) {
    $movie = Movie::get($id);
} else {
    $movie = new Movie();
}

view('movies-form', compact('movie'));
