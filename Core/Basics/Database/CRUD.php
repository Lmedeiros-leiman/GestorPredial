<?php 
// a wrapper class for the database class.
// it simplifies data down to 4 commands.

use Core\Basics\Database\Database;

class CRUD extends Database {

    public static function create($table, $data) {}
    public static function read($table, $data) {}
    public static function update($table, $data) {}
    public static function delete($table, $data) {}

    public static function fetchAll($table, $data) {}
    public static function fetchByCondition($table, $data) {}
    public static function fetchByKey($table,$data,$key) {}
}


?>