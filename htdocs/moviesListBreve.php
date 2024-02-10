<?php
$misqli = require __DIR__ . "\database.php";
//listagem dos filmes com estado brevemente
$sqlbrevemente = "Select * from filme Where estado='Brevemente'";
$resultbrevemente = mysqli_query($mysqli, $sqlbrevemente);
if ($resultbrevemente && isset($_SESSION["user_id"])) {
    echo '<H1 style="text-align: center;">Filmes Brevemente</H1>';
    while ($row = mysqli_fetch_assoc($resultbrevemente)) {
        $moviename = $row['moviename'];
        $estado = $row['estado'];
        $cover = $row['cover'];
            echo '<div id="grid" class="grid"> 
                    <H3>'.$moviename.'</H3>
                    <img src="/movies/'.$cover.'">
                    <label>'.$estado.'</label>
                    </div>';
            }
}
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