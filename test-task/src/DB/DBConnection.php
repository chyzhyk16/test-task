<?php
namespace App\DB;
class DBConnection
{
    public function __construct(DBConfig $config)
    {
        $this->connection = $config->getDB();
    }
}