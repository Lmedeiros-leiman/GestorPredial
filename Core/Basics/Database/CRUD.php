<?php 
// a wrapper class for the database class.
// it simplifies data down to 4 commands.
namespace Core\Basics\Database;

use Core\Basics\Database\Database;

class CRUD extends Database {

    public function create($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
    }

    public function read($table, $conditions = []) {
        $sql = "SELECT * FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_map(function($key) {
                return "$key = :$key";
            }, array_keys($conditions)));
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchAll();
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