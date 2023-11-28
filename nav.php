<?php
session_start();
if (isset($_GET['mensagem_sucesso'])) {
  $mensagemSucesso = urldecode($_GET['mensagem_sucesso']);
  echo "<script>alert('$mensagemSucesso');</script>";
}  
require_once '../projetoquartosemestre/classes/usuarios.php';
$idEspecifico = 34;


$objUsuario = new Usuario();
$objUsuario-> conectar( "cadastro_cliente", "localhost", "root", "admin");
$usuario = $objUsuario->obterDadosUsuarioLogado();


if(isset($_SESSION['id'])){
  $saudacao = '
  <li class="nav-item dropdown">
      <a class="cabecalho-item nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Olá, ' . $usuario['nome'] . '!
      </a>
      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="suaconta.php">Perfil</a></li>
          <li><hr class="dropdown-divider"></li>
          ';
          
          if (($usuario['id']) == $idEspecifico) {
            $saudacao .= '<li><a class="dropdown-item" href="visualizar_produtos.php">Área Restrita</a></li>
            <li><hr class="dropdown-divider"></li>
            ';
        }
    
        $saudacao .= '
                    <li><a class="dropdown-item" href="sair.php">Sair</a></li>
                </ul>
            </li>
        ';
} else {
  $saudacao = "Login/Cadastrar";
}

?>

<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Tons de Beleza</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="files/icon.png">
    <link rel="stylesheet" type="text/css" href="inicio.css">
    <link rel="shortcut icon" href="https://i.imgur.com/gBQhCJ6.png" type="x-icon">

    <!-- Chatbot -->
    <link rel="stylesheet" href="../projetoquartosemestre/chatbot/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/6c1b2d82eb.js' crossorigin='anonymous'></script>
</head>
<style>
  body{
   margin: 0;
   padding: 0;

}
h3{
    text-align: center;
    color: #770624;
}
.cabecalho{
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 24px;
}
.cabecalho-item{
    color: #963c54;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: 400;
}
.nav-item{
    display: flex;
    flex-direction: row;
    padding: 15px;
    text-decoration: underline;
    margin: 10px;
}
#carouselExampleIndicators{
   padding: 30px;
}
ul{
    display: flex;
    flex-direction: row;
    list-style: none;
    gap: 20px;
   justify-content: center;
   margin: 10px;
}

li{
    color: #963c54;
}
</style>


<body>
  <div class="caixinha"> </div>
  <!-- <div class="cont">
    <img  src="img/20231025_faixa_topo_desk.avif" alt="banner">
  </div>  --->
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">
        <a class="logo"> <img class="logo2" src="https://i.imgur.com/gBQhCJ6.png" height="60"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="cabecalho-item" href="notificacoes.html">Notificações<ion-icon class="icon" name="notifications-outline"></ion-icon></a>
            </li>
            <li class="nav-item">
              <a class="cabecalho-item" href="telainicial.php">Inicio <ion-icon class="icon" name="home-outline"></ion-icon>
            <li class="nav-item">
              <a class="cabecalho-item" href="salvos.php">Salvos <ion-icon class="icon" name="heart-outline"></ion-icon></a>
            </li>
            <li class="nav-item">
            <a class="cabecalho-item" href="suaconta.php">Minha Conta <ion-icon  class="icon" name="person-outline"></ion-icon></a> 

        </li>
            <li class="nav-item">
              <a class="cabecalho-item" href="carrinho.php">Sacola <ion-icon name="bag-handle-outline"></ion-icon></a>
            </li>
            <li class="nav-item">
                <a class="cabecalho-item" href="login2.php"><?= $saudacao; ?></a>
            </li>
          </ul>
          <form class="d-flex" method="get" role="search" action="resultados_busca.php">
            <input class="form-control me-2" type="search" name="nome_produto" placeholder="Pesquisar" aria-label="Search">
            <button type="submit" class="btn-1">Pesquisar</button>
          </form>
        </div>
      </div>
    </nav>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
    
