<?php
session_start();
$misqli = require __DIR__ . "\database.php";
if (isset($_GET['rentid'])) {
    $idmovie = $_GET['rentid'];


if (isset($_SESSION["user_id"])) {
        $mysqli = require __DIR__ . "/database.php";
        $sqluser = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
        $result = $mysqli->query($sqluser);
        $user = $result->fetch_assoc();
}
// Mostrar filme especifico pelo id
    $sqlmovie = "SELECT * FROM filme WHERE idmovie=?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sqlmovie);
    $stmt->bind_param("i", $idmovie);
    $stmt->execute();
    $result = $stmt->get_result();
    $movie = $result->fetch_assoc();

    //informaçoes do pedido do aluguer
    $userid = $user['id'];
    $username = $user['nome'];
    $idmovie = $movie['idmovie'];
    $moviename = $movie['moviename'];
    $preco = $movie['preco'];
    $date = gmdate("F j, Y, g:i a");
    $rentstate='Devolver';
    
    //mudar o estado do filme para indisponivel
    $indisponivel = "Indisponivel";
    $sqlmoviestatus = "UPDATE filme SET estado=? WHERE idmovie=?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sqlmoviestatus);
    $stmt->bind_param("si", $indisponivel, $idmovie);
    $stmt->execute();
    $resultmovie = $stmt->get_result();
   
    //inserir o registo do pedido na tabela com as informaçoes
    $sqlhistory = "INSERT INTO renthistory 
    SET userid=?, username=?, idmovie=?, moviename=?,preco=?, datetim=?, rentState=?"  ;
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sqlhistory);
    $stmt->bind_param("isissss",$userid,$username,$idmovie,$moviename,$preco,$date,$rentstate);
    if($stmt->execute()){
        header("Location:/movies.php" ); 
    }else{
        echo("ERRO");
    }
}


?>