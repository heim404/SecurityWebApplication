<?php
$misqli = require __DIR__ . "/database.php";
//apagar filme
if(isset($_GET['deletemovieid'])){
    $idmovie=$_GET['deletemovieid'];
    $sql="DELETE FROM filme WHERE idmovie=$idmovie";
    $result = mysqli_query($misqli,$sql);
    if($result){
        header("Location:../admin.php");
    }else{
        echo "erro";
    }
}

?>