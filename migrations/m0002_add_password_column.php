<?php

use app\core\Application;

class m0002_add_password_column
{
    public function up(): void
    {
        $db = Application::$app->db;
        $sql = "ALTER TABLE users ADD COLUMN password VARCHAR(255) NOT NULL";
        $db->pdo->exec($sql);
    }

    public function down(): void
    {
        $db = Application::$app->db;
        $sql = "ALTER TABLE users DROP COLUMN password";
        $db->pdo->exec($sql);
    }
}