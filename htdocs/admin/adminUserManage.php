<?php
//VISUALIZAÇÂO DOS USERS E GESTAO
$misqli = require __DIR__ .  "/database.php";
$adminId = $_SESSION["user_id"];
$sql = "Select * from user WHERE id!=$adminId";
$result = mysqli_query($mysqli, $sql);
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        $nome = $row['nome'];
        $email = $row['email'];
        $password_hash = $row['password_hash'];
        $user_type = $row['user_type'];
        echo '<tr>
                <th scope="row">'.$id.'</th>
                <td>'.$nome.'</td>
                <td>'.$email.'</td>
                <td>'.$password_hash.'</td>
                <td>'.$user_type.'</td>
                <td>
                    <button><a href="admin/adminUserUpdate.php?updateid='.$id.'">Update</a></button>
                    <button><a href="admin/adminUserDelete.php?deleteid='.$id.'">Delete</a></button>
                </td>       
            </tr>';
    }
}
?>

