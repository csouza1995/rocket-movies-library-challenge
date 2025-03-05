<?php

return new class extends MigrationBase
{
    public function up()
    {
        $this->db->exec("CREATE TABLE user_movies (
            id INTEGER PRIMARY KEY AUTOINCREMENT,            
            user_id INTEGER,
            movie_id INTEGER,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (movie_id) REFERENCES movies(id)
        )");
    }

    public function down()
    {
        $this->db->exec("DROP TABLE IF EXISTS user_movies");
    }
};
