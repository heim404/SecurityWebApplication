<?php
use LDAP\Result;
session_start();
//info do user logado {$_SESSION["user_id"]}
if (isset($_SESSION["user_id"])){
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user WHERE id = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

//se nao existir nenhum user logado bloquear acesso 
//redirecionando para login.
if (empty($_SESSION)){
    header("Location: login.php");
}

//se nao for admin destroy a sessão e redireciona 
//para o logout e depois para a pagina incial.
if (isset($user) && $user["user_type"] == "user") {
  session_destroy();
  header("Location: logout.php");
  exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pagina Inicial</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
    
<header>

</header>
<body>

<div class="topbar">
    <h3>Bem vindo Administrador <br> <?= htmlspecialchars($user["nome"]) ?></h3>
</div>
<a href="index.php">Voltar a pagina inicial</a>
<p>Opções de Administrador</P>

<!-- ------------------------------------------------------------------------------->
<!------------------------- ADD USER AS ADMIN ------------------------------------->
<div>
<button onclick="funcaoAddUser()">Adicionar utilizadores</button>
</div>

<div id="adduser" class="adduser" style="display: none;">
     <form action="admin/adminUserAdd.php" method="post" novalidate>
        <div>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome">
        </div>
        <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
        </div>
        <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        </div>
        <div>
        <label for="user_type">Tipo</label>
        <input type="radio" name="user_type" id="admin" value="admin">Admin
        <input type="radio" name="user_type" id="user" value="user">User
        </div>
        <button style="background-color: green;">Adicionar Utilizador</button>
    </form>
</div>
<!-- ------------------------------------------------------------------------------->
<!------------------------- ADD MOVIE AS ADMIN ------------------------------------->
<div>
<button onclick="funcaoAddMovie()">Adicionar Filmes</button>
</div>

<div id="addmovie" class="addmovie" style="display: none;">
     <form action="admin/adminMovieAdd.php" method="post" validate>
        <div>
        <label for="nome">Nome do Filme</label>
        <input type="text" name="moviename" id="moviename">
        </div>
        <div>
        <label for="preco">Preco</label>
        <input type="text" id="preco" name="preco">
        </div>    
    <div>
        <label for="estado">Estado</label>
        <input type="radio" name="estado" id="Disponivel" value="Disponivel" required>Disponivel</input>
        <input type="radio" name="estado" id="Indisponivel" value="Indisponivel">Indisponivel</input>
        <input type="radio" name="estado" id="Brevemente" value="Brevemente">Brevemente </input>
    </div>
    <div>
        <label for="Image">Imagem</label>
        <input type="file" accept="movies/*" id="cover" name="cover" width="80px" height="130px" object-fit:cover; required>
    </div>
  
        <button style="background-color: green;">Adicionar Filme</button>
    </form>
</div>
<!-- ------------------------------------------------------------------------------->
<!------------------------- VER LISTA USERS COMO ADMIN ------------------------------------->
<div>
<button onclick="funcaoshowuser()">Ver listagem Utilizadores</button>
</div>

<div id="showuser" class="showuser" style="display: none;">
<table>
  <tr>
    <th>ID</th>
    <th>NOME</th>
    <th>EMAIL</th>
    <th>PASSWORD</th>
    <th>TIPO</th>
    <th>Operação</th>
  </tr>
  
<?php
require "admin/adminUserManage.php";
?>
</table>
</div>
<!-- ------------------------------------------------------------------------------->
<!------------------------- VER LISTA FiLMES COMO ADMIN ------------------------------------->
<div>
<button onclick="funcaoshowmovie()">Ver listagem Filmes</button>
</div>
<div id="showmovie" class="showmovie" style="display: none;">
<table>
  <tr>
    <th>IDMOVIE</th>
    <th>NOME</th>
    <th>PRECO</th>
    <th>ESTADO</th>
    <th>COVER</th>
    <th>OPERAÇÂO</th>
  </tr>
<?php
require "admin/adminMovieManage.php";
?>
</table>
</div>

<!-- ------------------------------------------------------------------------------->
<!------------------------- VER HISTORICO DE ALUGUERES POR ID ------------------------------------->


<div>
<button onclick="funcaoshowrent()">Ver Historico Alugueres</button>

<div id="showrent" class="showrent" >
<html>
<form name="form" method="GET">
    <label>ID do Utilizador</label>
    <input type="search" name="userid" placeholder="ID" onclick="listopen">
</form>
</html>
<table>
  <tr>
    <th>ALUGUER ID</th>
    <th>NOME CLIENTE</th>
    <th>ID FILME</th>
    <th>NOME FILME</th>
    <th>PRECO</th>
    <th>DATA ALUGUER</th>
    <th>DATA ENTREGA</th>
  </tr>
<?php
require "admin/adminRentManage.php";
?>
</div>
</table>
</div>
</body>
</html>



<style> 

   /* .adduser,.showuser,.showmovie, .addmovie{
    display: none;
  }
     */
    .showrent{
    display: block;
   } 

    .topbar{
        display: flexbox;
        text-align: center;
    }
    a{
        text-align: left;
    }
    h3{
        text-align: center;
    }
</style>

<script>

function funcaoAddUser() {
    var x = document.getElementById("adduser");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
function funcaoAddMovie() {
    var x = document.getElementById("addmovie");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function funcaoshowuser() {
    var y = document.getElementById("showuser");
  if (y.style.display === "none") {
    y.style.display = "block";
  } else {
    y.style.display = "none";
  }
}

function funcaoshowmovie() {
    var y = document.getElementById("showmovie");
  if (y.style.display === "none") {
    y.style.display = "block";
  } else {
    y.style.display = "none";
  }
}

function funcaoshowrent() {
    const y = document.getElementById("showrent");
    if (y.style.display === "none") {
    y.style.display = "block";
  } else {
    y.style.display = "none";
  }
}
function listopen() {
    const y = document.getElementById("showrent");
    if (y.style.display === "none") {
    y.style.display = "block";
  } else {
    y.style.display = "block";
  }
}

</script>
<!--   -->