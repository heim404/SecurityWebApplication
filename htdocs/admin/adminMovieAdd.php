<?php
$mysqli = require __DIR__ . "/database.php";
//adicionar filmes novos 
$sql = "INSERT INTO filme (moviename, preco, estado, cover)
            VALUES(?,?,?,?)";
$stmt = $mysqli->stmt_init();
if ( ! $stmt->prepare($sql)){
    die("SQL ERROR" . $mysqli->error);
}
$stmt->bind_param("ssss",
                         $_POST["moviename"], 
                         $_POST["preco"], 
                         $_POST["estado"],
                         $_POST["cover"]);
if($stmt->execute()){
    header("Location: ../admin.php");
} 
?>