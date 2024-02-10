<?php
$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //validacao de inputs
    if (!preg_match("/[a-zA-Z]/", $_POST["nome"])) {
        echo "Nome apenas devera conter letras";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        echo "É preciso um email valido";
    } elseif (strlen($_POST["password"]) < 10) {
        echo 'Password tem que ter pelo menos 10 caracteres';
    } elseif (!preg_match("/[A-Z]/", $_POST["password"])) {
        echo "Password devera conter uma letra maiuscula";
    } elseif (!preg_match("/[a-z]/", $_POST["password"])) {
        echo "Password devera conter uma letra minuscula";
    } elseif (!preg_match("/[0-9]/", $_POST["password"])) {
        echo"Password devera conter pelo menos um numero";
    } elseif (!preg_match("/[!@#%^&-]/", $_POST["password"])) {
        echo  "Password devera conter pelo menos um caracter
                especial e nao pode conter $*";
                //confirmacao das passwords se sao iguais
    } elseif ($_POST["password"] !== $_POST["password_conf"]) {
        echo "As passwords têm que ser iguals";
    } else {
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (nome, email, password_hash) VALUES(?,?,?)";
        $stmt = $mysqli->stmt_init();
        if (!$stmt->prepare($sql)) {
            die("SQL ERROR" . $mysqli->error);}
        $stmt->bind_param("sss",$_POST["nome"],$_POST["email"],$password_hash);
        if ($stmt->execute()) {
            header("Location: signup-sucess.html");
            exit;
        } else {
            //se obtivermos o erro 1062 significa que o email ja esta inserido na bd
            if ($mysqli->errno === 1062) {
                echo "Email ja se encontra registado";
            } else {
                die($mysqli->error . " " . $mysqli->errno);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registar</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
    
<body>
    <a href="index.php">Voltar a pagina inicial</a>
    <h1>Registar</h1>
    <form action="" method="post" >
        <div>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" required>
        </div>
        <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="password_conf">Repetir Password</label>
            <input type="password" name="password_conf" id="password_conf" required> 
        </div>
        <button type="submit">Registar</button>
    </form>
    <p><a href="login.php">Pretende efetuar o login?</a></p>
</body>

</html>
