<?php
//VISUALIZAÇÂO FILMES SEM ESTAR LOGADO
//mostramos os filmes todos sem ordem e estado
$misqli = require __DIR__ . "\database.php";
$sqldisponivel = "Select * from filme ";
$resultdisponivel = mysqli_query($mysqli, $sqldisponivel);
if ($resultdisponivel && !isset($_SESSION["user_id"])) {
    echo '<H1 style="text-align: center;">Filmes</H1>';
    while ($rowdisp = mysqli_fetch_assoc($resultdisponivel)) {
        $idmovie = $rowdisp['idmovie'];
        $moviename = $rowdisp['moviename'];
        $preco = $rowdisp['preco'];
        $estado = $rowdisp['estado'];
        $cover = $rowdisp['cover'];
        echo '<div id="grid" class="grid">
                <H3>'.$moviename.'</H3>
                <img src="/movies/'.$cover . '">
                </div>';
    }}
//VISUALIZAÇÂO FILMES COM LOGIN
//mostramos os filmes disponiveis com botao de alugar
    $sqldisponivel = "Select * from filme Where estado='Disponivel'";
    $resultdisponivel = mysqli_query($mysqli, $sqldisponivel);
if ($resultdisponivel && isset($_SESSION["user_id"])) {
    echo '<H1 style="text-align: center;">Filmes Disponiveis</H1>';
    while ($row = mysqli_fetch_assoc($resultdisponivel)) {
        $idmovie = $row['idmovie'];
        $moviename = $row['moviename'];
        $preco = $row['preco'];
        $estado = $row['estado'];
        $cover = $row['cover'];
        echo '<div id="grid" class="grid"> 
                    <H3>' . $moviename . '</H3>
                    <img src="/movies/'.$cover.'">
                    <label>' . $preco . '€</label>
                    <label>' . $estado . '</label>
                    <button class="btn" id="modal"><a href="userMovieRent.php?rentid='.$idmovie.'">
                    Alugar <i class="fas fa-cart-arrow-down"></i></a></button>
            </div>';
    }}           
?>
<style>
.grid {
display: inline-grid;
margin: 5px;
text-align: center;
border: solid black 1px;
border-radius: 3%;
}

.btn{
    margin-left: 5px;
}
img{
width: 150px; 
height: 200px; 
object-fit: cover;
}
</style>