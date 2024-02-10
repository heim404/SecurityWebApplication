<!DOCTYPE html>
<html>
<head>
    <title>Criar nova Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
    
<body>
<!-- Pagina para alteracao da password -->
<?php 

$selector = $_GET["selector"];
$validator = $_GET["validator"];
        //verifica se os tokens que estao no link  
    if (empty($selector) || empty($validator)){
        echo "Nao foi possivel validar o seu pedido";        
       } else {
        ///verifica se as tokens no link sao hexadecimais
    if(ctype_xdigit($selector) !==false && ctype_xdigit($validator) !==false){
?>
    <form action="includes/reset-password.php" method="post">
    <input type="hidden" name="selector" value="<?php echo $selector ?>">
    <input type="hidden" name="validator" value="<?php echo $validator ?>">
    <input type="text" name="pwd" placeholder="Insira a nova password">
    <input type="text" name="pwd-repeat" placeholder="Confirme a nova password">
    <button type="submit" name="reset-password-submit">Recuperar palavra passe</button>
    </form>   
<?php
        }
       }
?>
</body>

</html>
