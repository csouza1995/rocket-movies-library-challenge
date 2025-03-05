<?php

return new class extends MigrationBase
{
    public function up()
    {
        $this->db->exec("CREATE TABLE reviews (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            movie_id INTEGER,
            rating INTEGER,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
        )");
    }

    public function down()
    {
        $this->db->exec("DROP TABLE IF EXISTS reviews");
    }
};
