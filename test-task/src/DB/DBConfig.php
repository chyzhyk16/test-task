<?php
namespace App\DB;

use PDO;

class DBConfig
{
    public $host = "mysql_test-task";
    public $port = 3306;
    public $root = "root";
    public $root_password = "dbroot";

    public $db = "new_db";

    public function getDB()
    {
        return new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->db", $this->root, $this->root_password);

    }
}