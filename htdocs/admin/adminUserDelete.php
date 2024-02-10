<?php
$misqli = require __DIR__ . "/database.php";
if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];

    $sql="DELETE FROM user WHERE id=$id";
    $result = mysqli_query($misqli,$sql);
    if($result){
        header("Location: ../admin.php");
    }else{
        echo "erro";
    }
}

?>