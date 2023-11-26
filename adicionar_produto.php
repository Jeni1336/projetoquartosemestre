<?php

session_start();
$idEspecifico = 34;

// Replace 'YOUR_SPECIFIC_LOGIN' with the actual login you want to check
if (!isset($_SESSION['id']) || $_SESSION['id'] != $idEspecifico) {
  // Se não estiver autenticado ou não tiver o ID específico, redireciona para a página de login
  echo "Você não tem permissão para acessar!";
  header ("location:telainicial.php");
  exit();
}


require_once '../projetoquartosemestre/classes/produtos.php';
require_once '../projetoquartosemestre/classes/usuarios.php';


$produto = new Produto(); // Create an instance of the Produto class
$u = new Usuario();
$u-> conectar("cadastro_cliente", "localhost", "root", "admin");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Adicionar Produto</title>
    <link rel="shortcut icon" href="https://i.imgur.com/gBQhCJ6.png" type="x-icon">
    <link rel="stylesheet" type="text/css" href="cadastrarProduto1.css">
</head>
<style>
  .btn-1 {
    background-color: #770624;
    border-radius: 10px;
    color: white;
}
</style>

<body>
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
              <a class="cabecalho-item" href="salvos.html">Salvos <ion-icon class="icon" name="heart-outline"></ion-icon></a>
            </li>
            <li class="nav-item">
              <a class="cabecalho-item" href="suaconta.php">Minha Conta <ion-icon  class="icon" name="person-outline"></ion-icon></a>
            </li>
            <li class="nav-item">
              <a class="cabecalho-item" href="carrinho.php">Sacola <ion-icon name="bag-handle-outline"></ion-icon></a>
            </li>
          </ul>
          <form class="d-flex" method="get" role="search" action="resultados_busca.php">
            <input class="form-control me-2" type="search" name="nome_produto" placeholder="Pesquisar" aria-label="Search">
            <button type="submit" class="btn-1">Pesquisar</button>
          </form>
        </div>
      </div>
    </nav>
    <div class="caixa">
    <nav>
        <a class="logo"> <img src="../projetoquartosemestre/images/Logo-Bonito.png" height="60"></a>
    </nav>
    <div class="container mt-5">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Detalhes do Produto</h3>
            <div class="form-group">
                <label>Nome do Produto<span>*</span></label>
                <input type="text" name="produto_nome" class="form-control" required maxlength="50" placeholder="Nome do Produto">
            </div>
            <div class="form-group">
                <label>Descrição do Produto<span>*</span></label>
                <input type="text" name="produto_descricao" class="form-control" required maxlength="50" placeholder="Descricao do Produto">
            </div>
            <div class="form-group">
                <label>Preço do Produto<span>*</span></label>
                <input type="number" name="produto_preco" class="form-control" required maxlength="10" placeholder="Preço do Produto" min="0" max="99999">
            </div>
            <div class="form-group">
                <label>Quantidade do Produto<span>*</span></label>
                <input type="number" name="produto_quantidade" class="form-control" required maxlength="11" placeholder="Quantidade do Produto" min="0" max="99999">
            </div>
            <div class="form-group">
                <label>Imagem do Produto<span>*</span></label>
                <input type="text" name="produto_imagem" class="form-control" required placeholder="imgur.com.br/..">
            </div>
            <div class="form-group">
                <label>URL do Produto<span>*</span></label>
                <input type="text" name="produto_url" class="form-control" required maxlength="50" placeholder="'../projetoquartosemestre/'">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-secondary" name="add_produto">Cadastrar Produto</button>
                <a href="telainicial.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>


<?php
//verificar se clicou no botao
if (isset($_POST['add_produto'])) {
  $nome = ($_POST['produto_nome']);
  $descricao = ($_POST['produto_descricao']);
  $preco = ($_POST['produto_preco']);
  $quantidade = ($_POST['produto_quantidade']);
  $imagem = isset($_POST['produto_imagem']) ? $_POST['produto_imagem'] : '';
  $url_absoluta = ($_POST['produto_url']);

  // Verify if it's filled
  if (!empty($nome) && !empty($descricao) && !empty($preco) && !empty($quantidade) && !empty($imagem) && !empty($url_absoluta)) {
      $u->conectar("cadastro_cliente", "localhost", "root", "admin");

      if ($u->msgErro == "") {
          if ($produto->cadastrarProduto($nome, $descricao, $preco, $quantidade, $imagem, $url_absoluta)) {
              echo "adicionado ao bd";
          } else {
              // Handle the error or display a message
              echo "Erro ao cadastrar produto";
          }
      } else {
          echo "Erro: " . $u->msgErro;
      }
  } else {
      echo "Preencha todos os campos!";
  }
} else {
  echo "Botão não foi pressionado";
}

?>



<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
              <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
</body>
</html>



