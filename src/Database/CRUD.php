<?php

namespace Database;

use Database\bases\Database;

// Uma classe que abstrai o banco de dados.
// Passar a tabela que esta se referindo junto.

class CRUD {

    public function create($table, $data) {
        $colunms = implode(",", array_keys( $data ));
        $placeholders = ":" . implode(", :", array_keys( $data ));
        
        $query = "INSERT INTO $table ($colunms) VALUES ($placeholders)";
        return Database::query($query, $data);
    }
    public function read($table) {
        $query = "SELECT * FROM $table";
        return Database::query($query);
    }

    public function readId($table, $id) {
        $query = "SELECT * FROM $table WHERE id = :id";
        return Database::query($query, ["id" => $id]);
    }
    public function readLike($table, $data) {
        $whereClause = implode(" AND ", array_map(function($key) {
            return "$key LIKE :$key";
        }, array_keys($data)));

        $query = "SELECT * FROM $table WHERE $whereClause";
        return Database::query($query, $data);
    }
    public function readWhere($table, $data) {
        $whereClause = implode(" AND ", array_map(function($key) {
            return "$key = :$key";
        }, array_keys($data)));

        $query = "SELECT * FROM $table WHERE $whereClause";
        return Database::query($query, $data);
    }

    public function update($table, $oldDataId, $newData) {
        $setClause = implode(", ", array_map(function($key) {
            return "$key = :$key";
        }, array_keys($newData)));
        
        $query = "UPDATE $table SET $setClause WHERE id = :id";
        

        $newData['id'] = $oldDataId;
        return Database::query($query, $newData);
    }

    public function delete($table, $id) {
        $query = "DELETE FROM $table WHERE id = :id";
        return Database::query($query, ["id" => $id]);
    }
}

