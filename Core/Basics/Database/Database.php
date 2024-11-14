<?php
namespace Core\Basics\Database;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    protected $connection;
    
    public function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
    
    public static function checkDatabaseTables() {
        $db = self::getInstance();
        
        // Create migrations table if it doesn't exist
        $db->query("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration_name VARCHAR(255) NOT NULL,
                executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        return $db;
    }
    
    public function hasMigration($migrationName) {
        $stmt = $this->query(
            "SELECT COUNT(*) as count FROM migrations WHERE migration_name = ?",
            [$migrationName]
        );
        return $stmt->fetch()['count'] > 0;
    }
    
    public function logMigration($migrationName) {
        $this->query(
            "INSERT INTO migrations (migration_name) VALUES (?)",
            [$migrationName]
        );
    }
}


?>