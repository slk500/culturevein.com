<?php

declare(strict_types=1);

namespace Repository\Base;

use mysqli;

final class Database
{
    public mysqli $mysqli;

    public function __construct()
    {
        $parameters = include(__DIR__.'/../../../config/parameters.php');

        $this->mysqli = new mysqli(
            $parameters['db_server'],
            $parameters['db_user'],
            $parameters['db_pass'],
            $parameters['db_name']
        );

        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
        }
        $this->mysqli->set_charset("utf8");
    }

    public function fetch(string $query) : ?array
    {
        $stmt = $this->mysqli->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->store_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function execute(string $query)
    {
        $this->mysqli->multi_query($query);
        while ($this->mysqli->next_result()) {;}
    }
}