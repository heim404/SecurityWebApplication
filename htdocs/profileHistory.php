<html>
<?php

$mysqli = require __DIR__ . "/database.php";

if (isset($_SESSION["user_id"])){
    $sql = "SELECT * FROM user WHERE id = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
$userid = $_SESSION['user_id'];
//VISUALIZAÇÂO DOS USERS E GESTAO

$sql = "SELECT * FROM renthistory WHERE userid=$userid";
$result = mysqli_query($mysqli, $sql);
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $idmovie=$row['idmovie'];
        $rentid = $row['rentid'];
        $username = $row['username'];
        $moviename = $row['moviename'];
        $preco = $row['preco'];
        $datetim = $row['datetim'];
        $rentstate=$row['rentState'];
        
        ///se o estado do filme for devolver
        //damos print das info do filme com um botao para devolver
        if($rentstate == "Devolver"){
            echo '<tr>
                <td>' . $rentid . '</td>
                <td>' . $username . '</td>
                <td>' . $moviename . '</td>
                <td>' . $preco . '</td>
                <td>' . $datetim . '</td> 
                <td>
                    <button class="btn"><a href="userMovieReturn.php?rentid=' . $rentid . '&idmovie=' . $idmovie . '">
                        Entregar <i class="fa-solid fa-turn-down-left"></i></a></button>
                </td>
                <tr>';

                //se nao devolvemos as infos do filme com a sua data de entrega
            }else{
            echo '<tr>
            <td>' . $rentid . '</td>
            <td>' . $username . '</td>
            <td>' . $moviename . '</td>
            <td>' . $preco . '</td>
            <td>' . $datetim . '</td> 
            <td>' . $rentstate . '</td> 
            <tr>'
            ;}
        }
    }

?>
</html>