<?php

namespace App\db;

use App\mapper\RowMapper;
use Exception;
use mysqli;

class Database
{
    public function connect()
    {
        $servername = $_ENV['DATABASE_URL'];
        $username = $_ENV['DATABASE_USERNAME'];
        $password = $_ENV['DATABASE_PASSWORD'];
        $database = $_ENV['DATABASE_NAME'];
        $port = $_ENV['DATABASE_PORT'];

        $conn = new mysqli($servername, $username, $password, $database, $port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

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

    public function query(string $query, array $params)
    {
        $query = sprintf($query, ...$params);
        $connection = $this->connect();
        return $connection->query($query);
    }

    public function count(string $query): int
    {
        try {

            $connection = $this->connect();
            $result = $connection->query($query);
            $data = $result->fetch_assoc();

            return (int)$data['count'];

        } catch (Exception $e) {
            error_log("Exception: " . $e->getMessage());
            return -1;
        }
    }

    /**
     * @throws Exception
     */
    public function queryAllPaginated(string $query, string $countQuery, int $start, int $limit, RowMapper $mapper): PaginatedResponse
    {
        $offset = ($start - 1) * $limit;
        $limitQuery = " LIMIT $limit OFFSET $offset";

        $connection = $this->connect();
        $result = $connection->query($query . $limitQuery);

        $objects = array();
        $count = 0;
        $totalCount = 0;

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $object = $mapper->map($row);
                $count += array_push($objects, $object);
            }

            $totalCount = $this->count($countQuery);

            if($totalCount == -1){
                throw new Exception("Count query is not valid");
            }
        }

        return new PaginatedResponse($objects, $totalCount, $count);
    }
}

