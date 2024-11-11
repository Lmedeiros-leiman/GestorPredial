<?php
namespace Core\Basics\Database\Migration;

class SchemaBuilder {
    private $tableName;
    private $columns = [];
    private $foreignKeys = [];
    private $primaryKey = null;
    private $usedColumnNames = [];
    
    public function __construct($tableName) {
        $this->tableName = $tableName;
    }
    
    private function validateColumnName($name) {
        if (in_array($name, $this->usedColumnNames)) {
            throw new \Exception("Duplicate column name '$name' in table '{$this->tableName}'");
        }
        $this->usedColumnNames[] = $name;
    }
    
    public function id() {
        $this->validateColumnName('id');
        $this->columns[] = "`id` INT AUTO_INCREMENT";
        $this->primaryKey = "id";
        return $this;
    }
    
    public function string($name, $length = 255) {
        $this->validateColumnName($name);
        $this->columns[] = "`$name` VARCHAR($length) NOT NULL";
        return $this;
    }
    
    public function text($name) {
        $this->validateColumnName($name);
        $this->columns[] = "`$name` TEXT NOT NULL";
        return $this;
    }

    public function integer($name) {
        $this->validateColumnName($name);
        $this->columns[] = "`$name` INT NOT NULL";
        return $this;
    }

    public function boolean($name, $default = false) {
        $this->validateColumnName($name);
        $defaultValue = $default ? 'TRUE' : 'FALSE';
        $this->columns[] = "`$name` BOOLEAN NOT NULL DEFAULT $defaultValue";
        return $this;
    }
    
    public function timestamps() {
        $this->validateColumnName('created_at');
        $this->validateColumnName('updated_at');
        $this->columns[] = "`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $this->columns[] = "`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        return $this;
    }
    
    public function foreignId($name) {
        $this->validateColumnName($name);
        $this->columns[] = "`$name` INT NOT NULL";
        return $this;
    }
    
    public function foreignKey($column, $referenceTable, $referenceColumn = 'id') {
        if (!in_array($column, $this->usedColumnNames)) {
            $this->validateColumnName($column);
            $this->columns[] = "`$column` INT NOT NULL";
        }
        $this->foreignKeys[] = "ALTER TABLE `{$this->tableName}` ADD CONSTRAINT `fk_{$column}` FOREIGN KEY (`$column`) REFERENCES `$referenceTable`(`$referenceColumn`)";
        return $this;
    }
    
    public function nullable() {
        if (empty($this->columns)) {
            throw new \Exception("Cannot call nullable() before defining a column");
        }
        $lastIndex = count($this->columns) - 1;
        $this->columns[$lastIndex] = str_replace('NOT NULL', 'NULL', $this->columns[$lastIndex]);
        return $this;
    }
    
    public function build() {
        if (empty($this->columns)) {
            throw new \Exception("No columns defined for table '{$this->tableName}'");
        }

        $sql = "CREATE TABLE IF NOT EXISTS `{$this->tableName}` (\n    ";
        $sql .= implode(",\n    ", $this->columns);
        
        if ($this->primaryKey) {
            $sql .= ",\n    PRIMARY KEY (`{$this->primaryKey}`)";
        }
        
        $sql .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        foreach ($this->foreignKeys as $fk) {
            $sql .= "\n" . $fk . ";";
        }
        
        return $sql;
    }
}