<?php

$movies = (object) [
    (object) [
        'title' => 'Averngers: Endgame',
        'genre' => 'Action',
        'year' => 2019,
        'poster' => 'https://m.media-amazon.com/images/M/MV5BMTc5MDE2ODcwNV5BMl5BanBnXkFtZTgwMzI2NzQ2NzM@._V1_FMjpg_UX1000_.jpg' ?? 'https://placehold.co/400x450',
    ],
    (object) [
        'title' => 'Deadpool & Wolverine',
        'genre' => 'Action',
        'year' => 2023,
        'poster' => 'https://musicart.xboxlive.com/7/7e206d00-0000-0000-0000-000000000002/504/image.jpg' ?? 'https://placehold.co/400x450',
    ],
    (object) [
        'title' => 'Inside Out 2',
        'genre' => 'Animation',
        'year' => 2022,
        'poster' => 'https://lumiere-a.akamaihd.net/v1/images/gife454xsaa8wv-_3e8071e7.jpeg' ?? 'https://placehold.co/400x450',
    ],
    (object) [
        'title' => 'Dungeons & Dragons: Honor Among Thieves',
        'genre' => 'Fantasy',
        'year' => 2023,
        'poster' => 'https://m.media-amazon.com/images/M/MV5BOGRjMjQ0ZDAtODc0OS00MGY1LTkxMTMtODhhNjY5NTM4N2IwXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg' ?? 'https://placehold.co/400x450',
    ],
    (object) [
        'title' => 'The Shawshank Redemption',
        'genre' => 'Drama',
        'year' => 1994,
        'poster' => 'https://m.media-amazon.com/images/I/61-vQDr7ecL._AC_UF894,1000_QL80_.jpg' ?? 'https://placehold.co/400x450',
    ],
    (object) [
        'title' => 'The Godfather',
        'genre' => 'Crime',
        'year' => 1972,
        'poster' => 'https://m.media-amazon.com/images/M/MV5BYTJkNGQyZDgtZDQ0NC00MDM0LWEzZWQtYzUzZDEwMDljZWNjXkEyXkFqcGc@._V1_.jpg' ?? 'https://placehold.co/400x450',
    ],
    (object) [
        'title' => 'The Dark Knight',
        'genre' => 'Action',
        'year' => 2008,
        'poster' => 'https://m.media-amazon.com/images/S/pv-target-images/e9a43e647b2ca70e75a3c0af046c4dfdcd712380889779cbdc2c57d94ab63902.jpg' ?? 'https://placehold.co/400x450',
    ],
    (object) [
        'title' => 'Harry Potter and the Sorcerer\'s Stone',
        'genre' => 'Fantasy',
        'year' => 2001,
        'poster' => 'https://m.media-amazon.com/images/M/MV5BNTU1MzgyMDMtMzBlZS00YzczLThmYWEtMjU3YmFlOWEyMjE1XkEyXkFqcGc@._V1_.jpg' ?? 'https://placehold.co/400x450',
    ],
    (object) [
        'title' => 'The Lord of the Rings: The Return of the King',
        'genre' => 'Fantasy',
        'year' => 2003,
        'poster' => 'https://m.media-amazon.com/images/M/MV5BYzZjOWMzNzMtZWZhYy00OWExLWJiYmEtMDE4NzdkNDJhMzZhXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg' ?? 'https://placehold.co/400x450',
    ],
];

// $movies = [];

view('index', compact('movies'));
