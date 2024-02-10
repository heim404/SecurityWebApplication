<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //validacao de inputs
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        echo "É preciso um email valido";
        if (strlen($_POST["password"]) < 10) {
            echo "Password tem que ter pelo menos 8 caracteres";
            if (!preg_match("/[A-Z]/", $_POST["password"])) {
                echo "Password devera conter uma letra maiuscula";
                if (!preg_match("/[a-z]/", $_POST["password"])) {
                    echo "Password devera conter uma letra minuscula";
                    if (!preg_match("/[0-9]/", $_POST["password"])) {
                        echo "Password devera conter pelo menos um numero";
                        if (!preg_match("/[!@#%^&-]/", $_POST["password"])) {
                            echo "Password precisa 1 char especial sem ser *$";
                        }
                    }
                }
            }
        }
    } else {

        $misqli = require __DIR__ . "/database.php";
        $sql = sprintf(
            "SELECT * FROM user  WHERE email = '%s'",
            $mysqli->real_escape_string($_POST["email"])
        );
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();
        if (empty($user)) {
            echo "Utilizador nao existe";
        } else {
            ///verificamos se a pw do post é igual a da base de dados
            if (password_verify($_POST["password"], $user["password_hash"])) {
                ///vericacao da opçao remember me
                //se sim, criamos um cookie com o id do user e damos enconde com o salt e tempo de duracao
                if (!empty($_POST["remember"])) {
                    $salt = '28n1ye1d2y8y7y1deui1ged287';
                    $encryptcookie = base64_encode($salt . "," . $user['id']);
                    setcookie("sawcookie", $encryptcookie, time() + 200);
                } else {
                    setcookie("sawcookie", "");
                }
                session_start();
                session_regenerate_id();
                $_SESSION["user_id"] = $user["id"];
                header("Location: index.php");
                exit;
            } else {
                echo "Password errada";
            }
        }
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>LOGIN</h1>
    <a href="index.php">Voltar a Pagina Inicial</a><br><br>
    <form method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" 
        value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>">    
        <label for="password">Password</label>
        <input type="password" name="password" id="password" 
        value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">  
        <p><input type="checkbox" name="remember" value="yes" />Lembrar</p>
        <button>Entrar</button>
    </form>
    <?php
        if (isset($_GET["newpwd"])){
            if($_GET["newpwd"] == "passwordupdated"){
            echo'A sua password foi atualizada!</p>'; }}
        ?>
     
            <p><a href="forgot-password.php">Recuperar conta?</a></p>
            <p><a href="registo.php">Pretende efetuar o registo?</a></p>
    
</body>
</html>