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

$produtos = $produto->obterTodosProdutos();

?>

<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="relatorio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/6c1b2d82eb.js' crossorigin='anonymous'></script>
    <title>Relatorio Produto</title>
</head>
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
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
              
              <ul>
                <hr>
                <li class="prod">
               Kit de Maquiagens
                </li>
                <li class="prod">
                  Paletas
                </li>
                <li class="prod">
                  Rosto
                </li>
                <li class="prod"> 
                 Olhos
                </li>
                <li class="prod"> 
                 Sobrancelhas
                </li>
                <li class="prod">
                Boca
                </li>
                <li class="prod">
                Pincéis
                </li>
                <li class="prod">
                Skin Care
                </li>
                <li class="prod">
                Só na TB
                </li>
                <li class="prod">
               Ofertas
                </li>
              </ul>

              <div class="container mt -3">
        <h2>Lista de Produtos</h2>
        <table class="table"> 
            <thead>
                <tr>
                    <th>Código do Produto</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Imagem</th>
                </tr>
            </thead>
        <tbody>
            <?php
            // Loop para exibir produtos
            if ($produtos) {
                foreach ($produtos as $produto) {
                    echo "<tr>";
                    echo "<td>{$produto['id']}</td>";
                    echo "<td>{$produto['nome']}</td>";
                    echo "<td>{$produto['descricao']}</td>";
                    echo "<td>R$" . number_format($produto['preco'], 2, ',', '.') . "</td>"; // Formatar o preço
                    echo "<td>{$produto['quantidade']}</td>";
                    echo "<td><img src='{$produto['imagem']}' alt='Miniatura'></td>";
                    // Adicione mais colunas conforme necessário
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum produto encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
 <div class="col-md-6 offset-md-3">
    <button type="submit" class="btn-1"> <a style="color: white;" href="adicionar_produto.php"> Cadastrar Novo </a> </button>
    <button type="submit" class="btn-1"> <a style="color: white;" href="telainicial.php"> Voltar </a> </button>
   </div>
</body>
</html>