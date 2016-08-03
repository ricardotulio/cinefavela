<?php

require_once("vendor/autoload.php");

$conn = new PDO("mysql:host=localhost", "root", "123456");
$sql = file_get_contents("data/schema.mysql.sql");
$conn->exec("DROP DATABASE IF EXISTS cinefavela_test");
$conn->exec("CREATE DATABASE cinefavela_test");
$conn->exec("USE cinefavela_test");
$conn->exec($sql); 
    