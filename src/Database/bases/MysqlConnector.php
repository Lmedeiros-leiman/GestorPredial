<?php

namespace Database\bases;

use PDO;

class MysqlConnector {
    public $connection = null;

    public function __construct() {
        $connector = new PDO("mysql:host=localhost;dbname=world", 'my_user', 'my_password');
    }



}

