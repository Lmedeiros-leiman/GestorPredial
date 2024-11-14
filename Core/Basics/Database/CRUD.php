<?php 
// a wrapper class for the database class.
// it simplifies data down to 4 commands.
namespace Core\Basics\Database;

use Core\Basics\Database\Database;
use PDO;

class CRUD extends Database {

    public function create($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
    }

    public function read($table, $conditions = []) {
        // First, get the table structure and foreign keys
        $columns = $this->getTableColumns($table);
        $joins = $this->getJoins($table);
        
        // Build the SELECT clause with aliased columns to avoid conflicts
        $select = [];
        $select[] = "$table.*";
        foreach ($joins as $join) {
            // Select all columns from referenced table with table prefix
            $referencedColumns = $this->getTableColumns($join['table']);
            foreach ($referencedColumns as $column) {
                $select[] = "{$join['table']}.{$column} AS {$join['table']}_{$column}";
            }
        }
        
        // Build the base query
        $sql = "SELECT " . implode(", ", $select) . " FROM $table";
        
        // Add joins
        if (!empty($joins)) {
            foreach ($joins as $join) {
                $sql .= " LEFT JOIN {$join['table']} ON {$join['condition']}";
            }
        }
        
        // Add conditions
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_map(function($key) use ($table) {
                return "$table.$key = :$key";
            }, array_keys($conditions)));
        }

        // Execute query
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($conditions);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Process results to create nested objects
        return $this->processResults($results, $table, $joins);
    }
    
    private function processResults($results, $table, $joins) {
        $processed = [];
        
        foreach ($results as $row) {
            $mainRecord = [];
            $foreignData = [];
            
            // Separate main table data and foreign key data
            foreach ($row as $column => $value) {
                if (strpos($column, '_') === false) {
                    // This is a column from the main table
                    $mainRecord[$column] = $value;
                } else {
                    // This is a column from a joined table
                    list($tableName, $columnName) = explode('_', $column, 2);
                    if (!isset($foreignData[$tableName])) {
                        $foreignData[$tableName] = [];
                    }
                    $foreignData[$tableName][$columnName] = $value;
                }
            }
            
            // Replace foreign keys with actual data
            foreach ($joins as $join) {
                $foreignKeyColumn = $this->getForeignKeyColumn($table, $join['table']);
                if (isset($mainRecord[$foreignKeyColumn]) && isset($foreignData[$join['table']])) {
                    // Replace the foreign key with the actual object
                    $mainRecord[$join['table']] = $foreignData[$join['table']];
                    // Optionally, remove the original foreign key
                    unset($mainRecord[$foreignKeyColumn]);
                }
            }
            
            $processed[] = $mainRecord;
        }
        
        return $processed;
    }
    
    private function getTableColumns($table) {
        $stmt = $this->connection->prepare("
            SELECT COLUMN_NAME 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = :table
        ");
        $stmt->execute(['table' => $table]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'COLUMN_NAME');
    }
    
    private function getForeignKeyColumn($table, $referencedTable) {
        $stmt = $this->connection->prepare("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_NAME = :table 
            AND REFERENCED_TABLE_NAME = :referenced_table
        ");
        $stmt->execute([
            'table' => $table,
            'referenced_table' => $referencedTable
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['COLUMN_NAME'] : null;
    }
    
    private function getJoins($table) {
        $joins = [];
        $stmt = $this->connection->prepare("
            SELECT 
                TABLE_NAME, 
                COLUMN_NAME, 
                REFERENCED_TABLE_NAME, 
                REFERENCED_COLUMN_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = :table 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        $stmt->execute(['table' => $table]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($result as $row) {
            $joins[] = [
                'table' => $row['REFERENCED_TABLE_NAME'],
                'condition' => "$table.{$row['COLUMN_NAME']} = {$row['REFERENCED_TABLE_NAME']}.{$row['REFERENCED_COLUMN_NAME']}"
            ];
        }
        return $joins;
    }


    public function update($table, $data, $conditions) {
        $set = implode(", ", array_map(function($key) {
            return "$key = :$key";
        }, array_keys($data)));
        
        $sql = "UPDATE $table SET $set WHERE " . implode(" AND ", array_map(function($key) {
            return "$key = :cond_$key";
        }, array_keys($conditions)));
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array_merge($data, array_combine(array_map(function($key) {
            return "cond_$key";
        }, array_keys($conditions)), $conditions)));
    }

    public function delete($table, $conditions) {
        $sql = "DELETE FROM $table WHERE " . implode(" AND ", array_map(function($key) {
            return "$key = :$key";
        }, array_keys($conditions)));
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($conditions);
    }
}


?>