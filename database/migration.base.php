<?php

class MigrationBase
{
    protected ?Database $db = null;

    public function __construct()
    {
        $this->db = new Database(config('database'));
    }
}
