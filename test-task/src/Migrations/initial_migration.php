<?php
$host = "mysql_test-task";
$port = 3306;
$root = "root";
$root_password = "dbroot";

$db = "new_db";

try {
    $dbh = new PDO("mysql:host=$host;port=$port;", $root, $root_password);

    $dbh->exec("CREATE DATABASE `$db`;");
    $dbh->exec("CREATE TABLE `new_db`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(64) NOT NULL , `email` VARCHAR(64) NOT NULL , `birth_date` DATE NOT NULL , `sex` TINYINT(2) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`name`), UNIQUE (`email`)) ENGINE = InnoDB;");

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}