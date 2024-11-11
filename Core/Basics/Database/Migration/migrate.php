<?php
namespace Core\Basics\Database\Migration;

use Core\Basics\Database\Database;
use Core\Basics\Database\Migration\SchemaBuilder as MigrationSchemaBuilder;
use Exception;

abstract class Migration {
    protected $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }
    abstract public function up();
    abstract public function down();

    protected function createTable($name, $callback) {
        $schema = new MigrationSchemaBuilder($name);
        $callback($schema);
        
        $this->db->query($schema->build());
    }
}

try {
    echo "Starting migrations...\n";
    
    // Initialize database and migrations table
    $db = Database::checkDatabaseTables();
    
    // Get all migration files
    $migrations = glob('Database/Migrations/*.php');
    
    foreach ($migrations as $migration) {
        // Get migration class name
        $className = 'Database\\Migrations\\' . basename($migration, '.php');
        
        // Skip if already executed
        if ($db->hasMigration($className)) {
            echo "Skipping {$className} - already executed\n";
            continue;
        }
        
        // Run migration
        require_once $migration;
        $migrationInstance = new $className($db);
        $migrationInstance->up();
        
        // Log successful migration
        $db->logMigration($className);
        echo "Executed {$className}\n";
    }
    
    echo "Migrations completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}



?>