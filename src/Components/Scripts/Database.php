<?php

class Database
{
    public static function query($query, $values = [])
    {
        $connection = new mysqli('db', $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"], 'GestorPredial');

        if ($connection->connect_error) {
            die('Connection failed: ' . $connection->connect_error);
        }

        $statement = $connection->prepare($query);

        if (!$statement) {
            die('Prepare failed: ' . $connection->error);
        }

        // Bind parameters dynamically
        if (!empty($values)) {
            $types = '';
            $params = [];

            // Build types string and params array
            foreach ($values as $value) {
                if (is_int($value)) {
                    $types .= 'i';
                } elseif (is_float($value)) {
                    $types .= 'd';
                } elseif (is_string($value)) {
                    $types .= 's';
                } else {
                    $types .= 'b';
                }
                $params[] = $value;
            }

            // Create reference array for bind_param
            $bindParams = array_merge([$types], $params);
            $refs = [];
            foreach ($bindParams as $key => $value) {
                $refs[$key] = &$bindParams[$key];
            }

            call_user_func_array([$statement, 'bind_param'], $refs);
        }

        $statement->execute();
        $result = $statement->get_result();
        $data = null;
        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
        }
        $statement->close();

        return $data;
    }
    private static function queryPDO($query, $values = [])
    {   
        // por algum motivo não consegui fazer funcionar com o PDO, mas deixei aqui o código para caso consiga resolver.
        // docker não instala o driver.

        $connection = new PDO("mysql:host=localhost;dbname=GestorPredial", $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"]);
        $statement = $connection->prepare($query);
        // Bind parameters dynamically
        foreach ($values as $key => $value) {
            $statement->bindValue(
                is_string($key) ? ":$key" : $key + 1,
                $value
            );
        }
        $statement->execute($values);
        return $statement->fetchAll();
    }

    public static function CheckDatabase()
    {
        // valida que o banco de dados existe.
        self::query("CREATE DATABASE IF NOT EXISTS GestorPredial");

        // cria a tabela de pessoas caso ela não exista.
        $query = "CREATE TABLE IF NOT EXISTS pessoas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            cpf VARCHAR(20) NOT NULL,
            telefone VARCHAR(255) NULL,
            unidade VARCHAR(255) NOT NULL,
            dataCriacao DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            dataAlteracao DATETIME NULL DEFAULT CURRENT_TIMESTAMP
        )";
        self::query($query);
    }
}
Database::CheckDatabase();
