<?php

$seeders = [
    'database/seeders/user.seeder.php',
    'database/seeders/movie.seeder.php',
];

foreach ($seeders as $seeder) {
    require $seeder;
}
