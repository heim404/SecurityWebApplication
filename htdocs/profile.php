<?php
session_start();

//verificao se existe alquem a aceder a pagina profile sem estar logado
//é redirecionado para o login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
}else{
    $sessionid=$_SESSION["user_id"];
}
$misqli = require __DIR__ . "\database.php";

if (isset($_POST["submit-profile"])) {
    $password = $_POST["password"];
    $password_conf = $_POST["password_conf"]; 
    //validacao dos inputs
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        echo "Valid email is required";
    if (strlen($_POST["password"]) < 10) {
        echo "Password tem que ter pelo menos 10 caracteres";
    if (!preg_match("/[A-Z]/i", $_POST["password"])) {
        echo "Password devera conter uma letra maiuscula";
    if (!preg_match("/[a-z]/i", $_POST["password"])) {
        echo "Password devera conter uma letra minuscula";
    if (!preg_match("/[0-9]/", $_POST["password"])) {
        echo "Password devera conter pelo menos um numero";
    if (!preg_match("/[!@#%^&-]/", $_POST["password"])) { //removido os caracteres * e $ para evitar ataques.
        echo "Password devera conter pelo menos um caracter especial e nao pode conter * ou $";
    }  }  }  }  } }  
    //verificacao se as passwords sao iguais
    elseif($password == $password_conf){
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        //damos update aos campos de utilizador a partir do id
        $sql = "UPDATE user SET nome=?, password_hash=?, fotourl=? WHERE id=?";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param("sssi", $_POST["nome"], 
                                    $password_hash , 
                                    $_POST["fotourl"], 
                                    $_SESSION["user_id"]);
        if($stmt->execute()){
        echo "<script>alert('Perfil Atualizado');</script>";
            } else{
        echo "<script>alert('ERRO Perfil nao foi atualizado');</script>";
    }   
    }else{
        echo "<script>alert('Password ERRADA');</script>";
    }
}
///APAGAR CONTA

    if (isset($_POST["deleteacc"])) {
        //verifica se o user tem filmes por devolver a partir do id da sessao(proprio user) e onde estado seja por devolver
        $rentstatus = "Select * from renthistory Where userid='.$sessionid' and where rentState='Devolver'";
        $resultstatus = mysqli_query($mysqli, $rentstatus);
        if(empty($resultstatus)){
            echo "<script>alert('Nao pode apagar a conta, tem filmes por entregar');</script>";
        }else{
            //damos delete ao utilizador correspondente ao id 
        $sqldel = "DELETE FROM user WHERE id=?";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($sqldel);
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        header("Location: logout.php");
        exit();
        } }  



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Bem vindo ao seu Perfil</title>
</head>

<body>
    <div>
        <p>Quer sair?<a href="logout.php">Log Out</a></p>   
        <a href="index.php">Voltar a Pagina Inicial</a>
        <h2>Profile</h2>
        <form action="" method="post">
            <?php
            $sql = "SELECT * FROM user WHERE id='{$_SESSION["user_id"]}'";
            $result = mysqli_query($mysqli, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div>
                <img src="/images/<?= $row["fotourl"] ?>" width="150px" height="150" alt="">
            </div>
            <div>
                <label>Nome</label>
                    <input type="text" id="nome" name="nome" placeholder="Nome Completo" value="<?php echo $row['nome']; ?>"
                    required> 
            </div>
            <div>
                <label>Email</label>
                <input type="email" id="email" name="email" placeholder="Email Address"
                    value="<?php echo $row['email']; ?>" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div>
                <label>Confirmação Password</label>
                <input type="text" id="password" name="password_conf" placeholder="Confirm Password" required>
            </div>
            <div>
                <label for="Image">Imagem</label>
                <input type="file" accept="images/*" id="fotourl" name="fotourl" value="<?=$row['fotourl']?>"> 
            </div>
            <?php
                }
            }
            
           
            ?>
            <!-- submeter alteracoes do user -->
            <div>
                <button type="submit" name="submit-profile" class="btn">Update Profile</button> <br>  
            </div>
            </form>
            <!-- apagar conta -->
            <form method="post">
                <button type="submit" name="deleteacc" class="btndel">Apagar Conta</button>
            </form >
            
            <div>
                <button type="button" onclick="funcaoshowhistory()" > Ver Historico Alugueres</button> <br>
             </div>
            

 <!-- tabela para mostar todos os Alugueres-->
    <div id="showhistory" class="showhistory" style="display: none;">
        <table>
            <tr>
                <th>RENT ID</th>
                <th>UTILIZADOR</th>
                <th>NOME FILME</th>
                <th>PRECO</th>
                <th>DATA ALUGUER</th>
                <th>DEVOLUÇÂO</th>
            </tr>
    
            <?php
        require "profileHistory.php";
        ?>
        </table>
    </div>


</div>
</body>

</html>

<style> 

    .btn{
       background-color: green;
    }
    .btndel{
       background-color: red;
    }
    
</style>
<script>
    function funcaoshowhistory() {
    var x = document.getElementById("showhistory");
    if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

</script>