<?php

$misqli = require __DIR__ . "/database.php";
$idmovie = $_GET['updatemovieid'];
$sql = "SELECT * FROM filme WHERE idmovie=?";
$stmt = $mysqli->stmt_init();
$stmt->prepare($sql);
$stmt->bind_param("i", $idmovie);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

//Na pag update vamos usar estas var para associar o valor antigo que ja temos na base de dados.
$moviename = $row['moviename'];
$preco = $row['preco'];
$cover = $row['cover'];

if (isset($_POST['submit'])) {
    $sql = "UPDATE filme SET moviename=?, preco=?, estado=?,cover=? WHERE idmovie=?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ssssi", $_POST["moviename"], 
                             $_POST["preco"], 
                            $_POST["estado"], 
                            $_POST["cover"],
                             $idmovie);
    if($stmt->execute()){
        echo "<script>alert('Filme foi atualizado');</script>";
    } else{
        echo "<script>alert('ERRO Filme nao foi atualizado');</script>";
    }   
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Movie Update</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<form method="post">
<?php
            $sql = "SELECT * FROM filme WHERE idmovie='$idmovie'";
            $result = mysqli_query($mysqli, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
    <div>
        <label for="moviename">Nome do Filme</label>
        <input type="text" name="moviename" id="moviename" value=<?php echo $row['moviename']; ?>>
    </div>
    <div>
        <label for="preco">Preco</label>
        <input type="text" id="preco" name="preco" required value=<?php echo $row['preco'];?>>
    </div>
    <div>
        <label for="estado">Estado</label>
        <input type="radio" name="estado" id="Disponivel" value="Disponivel" required>Disponivel</input>
        <input type="radio" name="estado" id="Indisponivel" value="Indisponivel">Indisponivel</input>
        <input type="radio" name="estado" id="Brevemente" value="Brevemente">Brevemente </input>
    </div>
    <br>
    <div>
        <label for="Image">Imagem</label>
        <input type="file" accept="movies/*" id="cover" name="cover" value="<?= $row['cover']?>" required>
    </div>
    <div>
        <img src="/movies/<?= $row["cover"] ?>" width="150px" height="150" alt="">
    </div>
    <?php
    }
} ?>
                
    <br>
    <button type="submit" name="submit">Update</button>

    <p><a href="../admin.php">Voltar a pagina de admin</a></p>
</form>

</html>
