<?php
namespace Core\Basics\Database\Migration;

use Core\Basics\Database\Database;

abstract class Migration {
    protected $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }
    abstract public function up();
    abstract public function down();

    protected function createTable($name, $callback) {
        $schema = new SchemaBuilder($name);
        $callback($schema);
        
        $this->db->query($schema->build());
    }
}


?>