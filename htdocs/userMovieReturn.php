<?php
session_start();
$misqli = require __DIR__ . "\database.php";
//ID DO ALUGER
if (isset($_GET['rentid'])) {
    $rentid = $_GET['rentid'];
}
if (isset($_GET['idmovie'])) {
    $idmovie = $_GET['idmovie'];
}


///MUDAR ESTADO DA TABELA FILME PARA DISPONIVEL
$sqlmovieDisponivel = "UPDATE filme SET estado=? WHERE idmovie=?";
$movieDispo = 'Disponivel';
$stmt = $mysqli->stmt_init();
$stmt->prepare($sqlmovieDisponivel);
$stmt->bind_param("si", $movieDispo, $idmovie);
$stmt->execute();


////MUDAR ESTADO DA TABELA RENTHISTORY
$sqlmoviereturn = "UPDATE renthistory SET rentstate=? WHERE rentid=?";
$returnDate=gmdate("F j, Y, g:i a");
$stmt = $mysqli->stmt_init();
$stmt->prepare($sqlmoviereturn);
$stmt->bind_param("si", $returnDate, $rentid);
if($stmt->execute()){
    header("Location:/profile.php" ); 
}else{
    echo 'ERRO AO DEVOLVER';
}

 ?>