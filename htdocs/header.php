<?php
session_start();
//verificaçao se existe uma cookie se sim iniciamos sessao com o id dentro dela
if(isset($_COOKIE['sawcookie']) && !isset($_SESSION["user_id"]) ){
    $data=base64_decode($_COOKIE['sawcookie']);
    $datacookie= explode('28n1ye1d2y8y7y1deui1ged287',$data);
    session_regenerate_id();
    $_SESSION["user_id"] = trim($datacookie[1], ",");
    
}

//obter informaçoes do user logado
if (isset($_SESSION["user_id"])){
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user WHERE id = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<header>
    <div class="navbar">
<ul>
  <p><a href="index.php">Pagina Inicial</a></p>
  <p><a href="movies.php">Filmes</a></p>
  <p><a href="contactos.php">Contactos</a></p>
     <?php if (isset($user) && $user["user_type"] == "admin"): ?>       
        <p><a href="profile.php"><?= htmlspecialchars($user["nome"])?> </a></p>
        <p><a href="admin.php">Admin</a></p>
        <p><a href="logout.php">Log out</a></p>
        <?php elseif (isset($user) && $user["user_type"] == "user"): ?>      
      <p><a href="profile.php"><?= htmlspecialchars($user["nome"])?></a></p> 
        <p><a href="logout.php">Logout</a></p>
    <?php else: ?>
        <p><a href="login.php">Entrar</a>/<a href="registo.php">Registar</a></p>
    <?php endif; ?>    
</ul>
</div>
</header>
</html>

<style>
ul{
    display: flex;
    text-decoration: none;
}
p{ 
    padding-right: 50px;
}

a:hover, a:visited, a:link, a:active{
    color: white;
    text-decoration: none;
}
header{text-align: center;}

</style>