<?php
session_start();
if (isset($_SESSION["user_id"])){
    session_destroy();
}?>
<!DOCTYPE html>
<html>
<head>
    <title>Recuperacao de password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>   
<body>
    <h1>Recuperação de conta</h1>
    <p>Insira o email da conta que pretende recuperar a password.</p>
    <form action="includes/reset-request.php" method="post" autocomplete="off">
        <input type="text" name="email" placeholder="O teu Email...">
        <button type="submit" name="reset-request-submit">Recuperar</button>
        <p><a href="login.php"> Voltar para a página de Login</a></p>
    </form>
    <?php
    if(isset($_GET["reset"])){
        if($_GET["reset"] == "success"){
            echo '<p class="loginsucess">Verifique o seu email!</p>';
        }
    }
    if(isset($_GET["reset"])){
        if($_GET["reset"] == "failed"){
            echo '<p class="loginfailed">Utilizador nao existe!</p>';
        }
    }
    ?>
</body>
</html>
