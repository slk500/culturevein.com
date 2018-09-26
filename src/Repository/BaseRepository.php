<?php


namespace Repository;


use mysqli;
use Symfony\Component\Dotenv\Dotenv;

class BaseRepository
{
    /**@var $mysqli mysqli**/
    protected $mysqli;

    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');

            $dbServer = getenv('DB_SERVER');
            $dbUser = getenv('DB_USER');
            $dbPass = getenv('DB_PASS');
            $dbName = getenv('DB_NAME');

        $this->mysqli = new mysqli($dbServer, $dbUser, $dbPass, $dbName);

        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
        }
        $this->mysqli->set_charset("utf8");
    }

    protected function execute(string $query) : ?array
    {
        $stmt = $this->mysqli->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();

        return $data;
    }
}