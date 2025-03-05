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
            user_id INTEGER,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            
            FOREIGN KEY (user_id) REFERENCES users(id)
        )");
    }

    public function down()
    {
        $this->db->exec("DROP TABLE IF EXISTS movies");
    }
};
