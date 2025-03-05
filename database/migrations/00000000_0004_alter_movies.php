<?php

return new class extends MigrationBase
{
    public function up()
    {
        $this->db->exec("ALTER TABLE movies ADD COLUMN rating DECIMAL(2, 1)");
    }

    public function down()
    {
        $this->db->exec("ALTER TABLE movies DROP COLUMN rating");
    }
};
