<?php

namespace App\db;

use App\mapper\RowMapper;
use mysqli;

class Database
{
    public function queryAll(string $query, RowMapper $mapper)
    {
        $connection = $this->connect();
        $result = $connection->query($query);
        $objects = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $object = $mapper->map($row);
                array_push($objects, $object);
            }
        }
        return $objects;
    }

    public function queryOne(string $query, RowMapper $mapper)
    {
        $connection = $this->connect();
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $mapper->map($row);
            }
        }
        return null;
    }

    public function connect()
    {
        $servername = "localhost";
        $username = "root";
        $password = "root12345";
        $database = "book_shop";
        $port = 3306;

        $conn = new mysqli($servername, $username, $password, $database, $port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public function query(string $query, array $params)
    {
        $query = sprintf($query, ...$params);
        $connection = $this->connect();
        return $connection->query($query);
    }
}

