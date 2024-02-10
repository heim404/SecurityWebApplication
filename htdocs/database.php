<?php

$host = "localhost";
$dbname = "login_db";
$username = "root";
$password = "passwordSAW";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno){
    die("Erro na conexao: " . $mysqli->connect_errno);
}
return $mysqli;