<?php

return new class extends MigrationBase
{
    public function up()
    {
        $this->db->exec("CREATE TABLE movies (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255),
            genre VARCHAR(255),
            year INTEGER,
            poster VARCHAR(255),
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function down()
    {
        $this->db->exec("DROP TABLE IF EXISTS movies");
    }
};
