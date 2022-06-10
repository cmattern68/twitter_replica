<?php

ini_set('display_errors', '1');

const HOST = "localhost";
const DATABASE = "message";
const USERNAME = "root";
const PASSWORD = "";

try {
    $database = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE, USERNAME, PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $error) {
    echo "probleme connexion : " . $error->getMessage();
}