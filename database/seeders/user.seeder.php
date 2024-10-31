<?php

$sql = file_get_contents('database/seeders/data/users.seeder.sql');

$database->exec($sql);

$users = $database->query('SELECT * FROM users')->fetchAll();

foreach ($users as $user) {
    $database->query(
        'UPDATE users SET password = :password WHERE id = :id',
        [
            'id' => $user->id,
            'password' => password_hash('password', PASSWORD_DEFAULT),
        ]
    );
}

echo 'Users seeded successfully' . PHP_EOL;
