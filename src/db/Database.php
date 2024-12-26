<?php

namespace App\db;

use mysqli;

class Database
{
    public function connect()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "book_shop";
        $port = 3306;

        $conn = new mysqli($servername, $username, $password, $database, $port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public function queryAll($query, $mapper){
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

    public function insert(string $query){
        $connection = $this->connect();
      return $connection->query($query);
    }
}

