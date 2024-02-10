<html>
<?php
//VISUALIZAÇÂO DOS USERS E GESTAO DE FILMES
$misqli = require __DIR__ . "/database.php";
$sql = "Select * from filme";
$result = mysqli_query($mysqli, $sql);
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $idmovie = $row['idmovie'];
        $moviename = $row['moviename'];
        $preco = $row['preco'];
        $estado = $row['estado'];
        $cover = $row['cover'];
        echo '<tr>
                <td>'.$idmovie.'</td>
                <td>'.$moviename.'</td>
                <td>'.$preco.'</td>
                <td>'.$estado.'</td>
                <td><img width="80px" height="130px" object-fit:cover; src="/movies/'.$cover.'"> </td>
                <td>
                    <button><a href="admin/adminMovieUpdate.php?updatemovieid='.$idmovie.'">Update</a></button>
                    <button><a href="admin/adminMovieDelete.php?deletemovieid='.$idmovie.'">Delete</a></button>
                </td>       
            </tr>';
    }
}
?>
<style>
img{
width: 80px; 
height: 100px; 
object-fit: cover;
}
</style>
</html>