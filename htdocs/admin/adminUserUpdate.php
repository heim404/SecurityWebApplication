<?php
$misqli = require __DIR__ . "..\database.php";
$id = $_GET['updateid'];
$sql = "SELECT * FROM user WHERE id=?";
$stmt = $mysqli->stmt_init();
$stmt->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
//Na pag update vamos usar estas var para associar o valor que ja temos na base de dados.
$nome = $row['nome'];
$email = $row['email'];

if (isset($_POST['submit-update'])) {
    ///Validar credencias
    if (empty($_POST["nome"])) {
        echo "name is required";
    }
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        echo "Valid email is required" ;
    }
    if (strlen($_POST["password"]) < 10) {
        echo "Password tem que ter pelo menos 10 caracteres";
    }
    if (!preg_match("/[A-Z]/i", $_POST["password"])) {
        echo "Password devera conter uma letra maiuscula";
    }
    if (!preg_match("/[a-z]/i", $_POST["password"])) {
        echo "Password devera conter uma letra minuscula";
    }
    if (!preg_match("/[0-9]/", $_POST["password"])) {
        echo "Password devera conter pelo menos um numero";
    }
    if (!preg_match("/[!@#%^&-]/", $_POST["password"])) { //removido os caracteres * e $ para evitar ataques.
        echo "Password devera conter pelo menos um 
            caracter especial e nao pode conter * ou $";
    }else{
        //hash pw
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $sql = "UPDATE user SET nome=?,email=?, password_hash=?,user_type=? WHERE id=?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ssssi", $_POST["nome"],  
                                $_POST["email"],
                                $password_hash,
                             $_POST["user_type"],
                                    $id);
    if($stmt->execute()){
        echo "<script>alert('Utilizador atualizado');</script>";
    } else{
        echo "<script>alert('ERRO ao atualizar Utilizador');</script>";
    }
}}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin User Update</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<form method="post">
    <div>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value=<?php echo $nome; ?>>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required value=<?php echo $email; ?>>
    </div>
    <div>
        <label for="password">Password</label>
        <input type="text" id="password" name="password" required autocomplete> </input>
    </div>
    <div>
        <label for="user_type">Tipo</label>
        <input type="radio" name="user_type" id="admin" value="admin">Admin
        <input type="radio" name="user_type" id="user" value="user">User
    </div>
    <button type="submit" name="submit-update">Update</button>
    <p><a href="../admin.php">Voltar a pagina de admin</a></p>
</form>

</html>

