<?php

return new class extends MigrationBase
{
    public function up()
    {
        $this->db->exec("CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100),
            surname VARCHAR(100),
            email VARCHAR(255),
            password VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function down()
    {
        $this->db->exec("DROP TABLE IF EXISTS users");
    }
};
