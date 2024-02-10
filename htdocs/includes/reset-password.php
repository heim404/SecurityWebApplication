<?php
///verifica se houve um post
if(isset($_POST["reset-password-submit"])){
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];
    //verifica se os campos das passwords estao vazias
    if (empty($password) || empty($passwordRepeat)) {
        header("Location: ../login.php?=newpwd=empty");
        exit();
        //verifica se as passwords sao diferentes
    } else if ($password != $passwordRepeat){
        header("Location: ../login.php?=newpwdnotsame");
        exit();
    }  elseif (strlen($_POST["pwd"]) < 10) {
        echo 'Password tem que ter pelo menos 10 caracteres';
    } elseif (!preg_match("/[A-Z]/", $_POST["pwd"])) {
        echo "Password devera conter uma letra maiuscula";
    } elseif (!preg_match("/[a-z]/", $_POST["pwd"])) {
        echo "Password devera conter uma letra minuscula";
    } elseif (!preg_match("/[0-9]/", $_POST["pwd"])) {
        echo"Password devera conter pelo menos um numero";
    } elseif (!preg_match("/[!@#%^&-]/", $_POST["pwd"])) {
        echo "Password devera conter pelo menos um caracter
                especial e nao pode conter $*";
    }else{

    $currentDate = date("U");
    require '../database.php';
    //verificacao da informacao da base de dados da recuperacao referente as 2 tokens
    $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector=? AND pwdResetExpires >=?";
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        echo ("Houve um erro");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_fetch_assoc($result)) {
            echo "Erro, tem que resubmeter o seu pedido de reset";
            exit();
            } else {
                //convertemos o token de hexadecimal para binario
                $tokenBin = hex2bin($validator);
                //verificamos se o token do link corresponde ao da base de dados
                $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);
                if ($tokenCheck === false) {
                    echo ("Erro, tem que resubmeter o seu pedido de reset");
                    exit();
                } elseif ($tokenCheck === true) {
                    $tokenEmail = $row['pwdResetEmail'];
                    //verificamos as info dos user a partir do email na token
                    $sql = "SELECT * FROM user WHERE email=?";
                    $stmt = mysqli_stmt_init($mysqli);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo ("Houve um erro");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if (!$row = mysqli_fetch_assoc($result)) {
                            echo "Houve um erro";
                            exit();
                        } else {
                            //damos update ao campo da password
                            $sql = "UPDATE user SET password_hash=? WHERE email=?"; 
                            $stmt = mysqli_stmt_init($mysqli);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo ("Houve um erro");
                                exit();
                            } else {
                                //damos hash da a password no post
                                $newPW = password_hash($_POST["pwd"], PASSWORD_DEFAULT); 
                                mysqli_stmt_bind_param($stmt, "ss", $newPW, $tokenEmail);
                                mysqli_stmt_execute($stmt);
                                //apagamos o pedido de recuperaçao da base de dados
                                $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?"; 
                                $stmt = mysqli_stmt_init($mysqli);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "Houve um erro!";
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: ../login.php?newpwd=passwordupdated");
                                }
                            }

                        }
                    }

                }
            }
        }
    }

}else {
    header("Location: ../index.php");
}