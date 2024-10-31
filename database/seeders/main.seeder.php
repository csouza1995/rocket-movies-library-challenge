<?php

$seeders = [
    'database/seeders/user.seeder.php',
];

foreach ($seeders as $seeder) {
    require $seeder;
}
