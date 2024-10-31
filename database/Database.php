<?php

class Database
{
    protected PDO $pdo;

    public function __construct($databaseConfig)
    {
        $this->pdo = new PDO($this->getDsn($databaseConfig));
    }

    protected function getDsn($config): string
    {
        $driver = $config['driver'];
        unset($config['driver']);

        return match ($driver) {
            'sqlite' => "sqlite:{$config['database']}",
            'mysql' => "mysql:" . http_build_query($config, '', ';'),
            default => throw new Exception('Driver not supported'),
        };
    }

    public function query($query, $params = [], $class = null): PDOStatement
    {
        $statement = $this->pdo->prepare($query);

        if ($class) {
            $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        } else {
            $statement->setFetchMode(PDO::FETCH_OBJ);
        }

        $statement->execute($params);

        return $statement;
    }

    public function exec($query, $killOnError = true)
    {
        try {
            return $this->pdo->exec($query);
        } catch (Exception $e) {

            if ($killOnError) {
                die($e->getMessage());
            }

            return false;
        }
    }

    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }

    public function rollBack()
    {
        return $this->pdo->rollBack();
    }
}

$database = new Database(config('database'));
