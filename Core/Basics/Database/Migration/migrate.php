<?php

namespace Core\Basics\Database\Migration;

spl_autoload_register(function ($class) {
    // Convert namespace separators to directory separators

    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Base directory for your classes
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

    // Build the full path
    $file = $baseDir . $class . '.php';
    // If the file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }
});

require_once __DIR__ . "/.." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Configurables" . DIRECTORY_SEPARATOR . "Configurables.php";

use Core\Basics\Database;
use Core\Basics\Database\Migration\SchemaBuilder as MigrationSchemaBuilder;
use Exception;



abstract class Migration
{
    protected $db;

    public function __construct(Database\Database $db)
    {
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
    $db = Database\Database::checkDatabaseTables();

    // Get all migration files
    $migrations = glob(__DIR__ ."/../Tables/*.php");
    
    foreach($migrations as $migration) {

        if ($db->hasMigration(basename($migration))) {
            echo "Skipping " . basename($migration) . " - already executed\n";
            continue;
        }
        // Get the filename without extension
        $className = pathinfo($migration, PATHINFO_FILENAME);
        // Create the fully qualified class name
        $fullClassName = "Core\\Basics\\Database\\Tables\\". $className;
        
        // Create instance using the full class name
        $migrationInstance = new $fullClassName($db);
        $migrationInstance->up();

        // Log successful migration
        $db->logMigration(basename($migration));
        echo "Executed " . basename($migration) . "\n";
    }

    echo "Migrations completed successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
