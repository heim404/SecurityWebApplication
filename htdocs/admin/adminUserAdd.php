<?php
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
        echo "Password devera conter pelo menos um numero";
    } elseif (!preg_match("/[!@#%^&-]/", $_POST["password"])) {
        echo "Password devera conter pelo menos um caracter
                especial e nao pode conter $*";
    } else {
        //hash da pw
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $mysqli = require __DIR__ . "/database.php";
        $sql = "INSERT INTO user (nome, email, password_hash, user_type)
            VALUES(?,?,?,?)";
        $stmt = $mysqli->stmt_init();
        if (!$stmt->prepare($sql)) {
            die("SQL ERROR" . $mysqli->error);
        }
        $stmt->bind_param(
            "ssss",
            $_POST["nome"],
            $_POST["email"],
            $password_hash,
            $_POST["user_type"]
        );
        if ($stmt->execute()) {
            header("Location: ../admin.php");
        }
    }
}
?>