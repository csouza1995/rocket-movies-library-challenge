<?php

$seeders = [
    'database/seeders/user.seeder.php',
    'database/seeders/movie.seeder.php',
    'database/seeders/user_movies.seeder.php',
];

foreach ($seeders as $seeder) {
    require $seeder;
}
