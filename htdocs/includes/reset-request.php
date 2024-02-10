<?php
if (isset($_POST["reset-request-submit"])) {
    require '../database.php';
    $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
    //verificar se o utilizador existe na base de dados.
    $mailcheck = "SELECT * FROM user WHERE email='".$email."'";
    $result = mysqli_query($mysqli, $mailcheck);
    $usermail = mysqli_num_rows($result);
    if ($usermail > 0) {
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $url = "localhost/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
        $expires = date("U") + 1800;

        $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?"; //Eliminar ja criadas na bd
        $stmt = mysqli_stmt_init($mysqli);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo ("Houve um erro 1");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
        }
        //Adicionar nova token na db
        $sql = "INSERT INTO pwdReset(pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($mysqli);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo ("Houve um erro 2");
            exit();
        } else {
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashedToken, $expires);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);



        // Construçao do corpo do email, usando PHPMailer e servidor email criado pelo aluno Marco Coelho.
        $to = $email;
        $subject = 'Recuperar palavra passe';
        $message = 'Um pedido de recuperacao de palavra passe foi recebida no sistema. 
            O link para definir a nova palavra passe encontra-se por baixo.
        ' . $url . '';
        require '../PHPMailer-5.2-stable/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPSecure = 'auto';
        $mail->SMTPAuth = true;
        $mail->Host = 'CHANGE_ME';
        $mail->Port = 'CHANGE_ME';
        $mail->Username = 'CHANGE_ME';
        $mail->Password = 'CHANGE_ME';
        $mail->setFrom('CHANGE_ME');
        $mail->addAddress($to);
        $mail->Subject = 'Pedido recuperacao palavra passe!';
        $mail->Body = ($message);

        //enviar mensagens e verificar erros
        if (!$mail->send()) {
            echo "ERROR: " . $mail->ErrorInfo;
        } else {
            header("Location: ../forgot-password.php?reset=success");
        }
    }
    else {
    header("Location: ../forgot-password.php?reset=failed");
    } 

}