<?php

namespace app\core\db;

use app\core\Application;

class Database
{
    public \PDO $pdo;
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $pass = $config['password'] ?? '';
        try {
            $this->pdo = new \PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo 'Error Happens';
        }
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $allMigrations = scandir(Application::$ROOT_DIR.'/migrations');
        $allMigrations = array_map(fn($m) => pathinfo($m, PATHINFO_FILENAME), $allMigrations);
        array_splice($allMigrations, 0, 2); // to remove '.' and '..'
        $toApplyMigrations = array_diff($allMigrations, $appliedMigrations);
        $newMigrations = [];

        if (!empty($toApplyMigrations)) {
            foreach ($toApplyMigrations as $migration) {
                require_once Application::$ROOT_DIR . '/migrations/'. $migration . '.php';
                $migration = pathinfo($migration, PATHINFO_FILENAME);
                $instance = new $migration();
                echo $this->log("Applying Migration $migration");
                $instance->up();
                echo $this->log("Successfully Applied: $migration");
                $newMigrations[] = $migration;
            }
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            echo $this->log('All Migrations are applied');
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;
        ");
    }

    public function getAppliedMigrations(): array|false
    {
        $stmt = $this->pdo->prepare('SELECT migration FROM migrations');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $sql = implode(',', array_map(fn($m) => "('$m')", $migrations));
        $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $sql");
        $stmt->execute();
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
    protected function log(string $message): string
    {
       return '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}