<?php

// set docroot
define('ROOT', dirname(__DIR__ . '/../../'));

require ROOT . "/functions.php";
require ROOT . "/database/Database.php";
require ROOT . "/database/migration.base.php";

$database = new Database(require "config/database.php");

// get params from command line
$rollback = in_array('--rollback', $argv);

$step = array_values(array_filter($argv, function ($arg) {
    return strpos($arg, '--step=') !== false;
}))[0] ?? false;
$step = $step !== false ? (int) explode('=', $step)[1] : 0;

$fresh = in_array('--fresh', $argv);

if ($fresh) {
    // get drop all tables
    $tables = $database->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll();

    foreach ($tables as $table) {
        if ($table->name === 'sqlite_sequence') {
            continue;
        }

        $database->exec("DROP TABLE {$table->name}");
    }
}

// check if migration table exists and if not create it
if ($database->query("SELECT name FROM sqlite_master WHERE type='table' AND name='migrations'")->fetch() === false) {
    $database->exec('CREATE TABLE migrations (
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        migration VARCHAR(255), 
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');
}

// get all migrations
$migrations = $database->query('SELECT * FROM migrations')->fetchAll();

// get all migration files
$migrationFiles = glob('database/migrations/*.php');

// order migration files
sort($migrationFiles);

// register migration
function registerMigration(string $name)
{
    global $database;
    $database->exec("INSERT INTO migrations (migration) VALUES ('{$name}')");
}

// unregister migration
function unregisterMigration(int $id)
{
    global $database;
    $database->exec("DELETE FROM migrations WHERE id = {$id}");
}

// run migrations
function runMigrations()
{
    global $migrations, $migrationFiles, $database, $step;
    $runnerCount = 0;

    foreach ($migrationFiles as $migrationFile) {
        $migrationClass = require $migrationFile;

        if (!in_array($migrationFile, array_column($migrations, 'migration'))) {
            echo 'Migrating ' . $migrationFile . PHP_EOL;

            try {
                $database->beginTransaction();

                $migrationClass->up();
                registerMigration($migrationFile);

                $database->commit();
            } catch (Exception $e) {
                $database->rollBack();
                echo 'Error: ' . $e->getMessage() . PHP_EOL;
                continue;
            }

            $runnerCount++;
            echo 'Migrated ' . $migrationFile . PHP_EOL;
        }

        if ($step > 0 && $runnerCount >= $step) {
            break;
        }
    }

    if ($runnerCount === 0) {
        echo 'Nothing to migrate' . PHP_EOL;
    } else {
        echo 'Migrated ' . $runnerCount . ' files' . PHP_EOL;
    }
}

// rollback migrations
function rollbackMigrations()
{
    global $migrations, $database, $step;

    $reverseMigrations = array_reverse($migrations);
    $runnerCount = 0;

    foreach ($reverseMigrations as $migration) {
        $migrationFile = $migration->migration;

        $migrationClass = require $migrationFile;

        echo 'Rolling back ' . $migrationFile . PHP_EOL;
        try {
            $database->beginTransaction();

            $migrationClass->down();
            unregisterMigration($migration->id);

            $database->commit();
        } catch (Exception $e) {
            $database->rollBack();
            echo 'Error: ' . $e->getMessage() . PHP_EOL;
            continue;
        }

        $runnerCount++;
        echo 'Rolled back ' . $migrationFile . PHP_EOL;

        if ($step > 0 && $runnerCount >= $step) {
            break;
        }
    }

    if ($runnerCount === 0) {
        echo 'Nothing to rollback' . PHP_EOL;
    } else {
        echo 'Rolled back ' . $runnerCount . ' files' . PHP_EOL;
    }
}

if ($rollback) {
    rollbackMigrations();
} else {
    runMigrations();
}
