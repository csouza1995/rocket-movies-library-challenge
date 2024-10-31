<?php

$sql = file_get_contents('database/seeders/data/movies.seeder.sql');

$database->exec($sql);

echo 'Movies seeded successfully' . PHP_EOL;
