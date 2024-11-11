<?php
namespace Core\Basics\Database\Migration;

class SchemaBuilder {
    private $tableName;
    private $columns = [];
    private $primaryKey = null;
    
    public function __construct($tableName) {
        $this->tableName = $tableName;
    }
    
    public function id() {
        $this->columns[] = "`id` INT AUTO_INCREMENT";
        $this->primaryKey = "id";
        return $this;
    }
    
    public function string($name, $length = 255) {
        $this->columns[] = "`$name` VARCHAR($length) NOT NULL";
        return $this;
    }
    
    public function text($name) {
        $this->columns[] = "`$name` TEXT NOT NULL";
        return $this;
    }
    
    public function timestamps() {
        $this->columns[] = "`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $this->columns[] = "`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        return $this;
    }
    
    public function foreignId($name) {
        $this->columns[] = "`$name` INT NOT NULL";
        return $this;
    }
    
    public function foreignKey($column, $referenceTable, $referenceColumn = 'id') {
        $this->columns[] = "FOREIGN KEY (`$column`) REFERENCES `$referenceTable`(`$referenceColumn`) ON DELETE CASCADE";
        return $this;
    }
    
    public function nullable() {
        $lastIndex = count($this->columns) - 1;
        $this->columns[$lastIndex] = str_replace('NOT NULL', 'NULL', $this->columns[$lastIndex]);
        return $this;
    }
    
    public function build() {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->tableName}` (\n";
        $sql .= implode(",\n", $this->columns);
        
        if ($this->primaryKey) {
            $sql .= ",\nPRIMARY KEY (`{$this->primaryKey}`)";
        }
        
        $sql .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        return $sql;
    }
} 