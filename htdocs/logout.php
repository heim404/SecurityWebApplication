<?php
session_start();
//verificamos se existe com, se sim eliminamos
if (isset($_COOKIE['sawcookie'])) {
    unset($_COOKIE['sawcookie']);
    setcookie('sawcookie', '', time() - 3600, '/');
} 
session_destroy();
header("Location: index.php");
exit();
?>