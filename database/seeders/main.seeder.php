<?php

$seeders = [
    'database/seeders/user.seeder.php',
    'database/seeders/movie.seeder.php',
    'database/seeders/user_movies.seeder.php',
    'database/seeders/reviews.seeder.php',
];

foreach ($seeders as $seeder) {
    require $seeder;
}
