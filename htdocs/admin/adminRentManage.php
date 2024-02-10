

<?php
//VISUALIZAÇÂO ALUGUERES HISTORICO POR ID
error_reporting(E_ALL ^ E_NOTICE);
if (!preg_match("/[0-9]/", $_GET["userid"])) {
    echo ("ID tera que ser um numero");
}else{
    $misqli = require __DIR__ . "/database.php";
    $sql = "Select * from renthistory WHERE userid='".$_GET['userid']."'";
    $result = mysqli_query($mysqli, $sql);
    if (empty($_GET["userid"])) {
        echo '<H3>Precisa de inserir um ID</H3>';
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            if (empty($row["rentid"])) {
                echo '<H3>Sem Historico de Alugueres</H3>';
            } else {
                $rentid = $row['rentid'];
                $username = $row['username'];
                $idmovie = $row['idmovie'];
                $moviename = $row['moviename'];
                $preco = $row['preco'];
                $datetim = $row['datetim'];
                $datereturn= $row['rentState'];
                echo '<tr>
                <td>' . $rentid . '</td>
                <td>' . $username . '</td>
                <td>' . $idmovie . '</td>
                <td>' . $moviename . '</td>
                <td>' . $preco . '</td>
                <td>' . $datetim . '</td>
                <td>' . $datereturn . '</td>
            </tr>';

            }
        }
    }}

?>