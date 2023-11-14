<?php
require_once '../projetoquartosemestre/classes/usuarios.php';
session_start();
if(!isset($_SESSION['id'])){
  header("location: login2.php"); 
  exit;
  }

$objUsuario = new Usuario();
$objUsuario->conectar("cadastro_cliente", "localhost", "root", "admin");

$usuario = $objUsuario->obterDadosUsuarioLogado();

if ($usuario) { 
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Cartão</title>
    <link rel="stylesheet" href="cartao.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <a class="cabecalho-item" href="carrinho.html">Sacola <ion-icon name="bag-handle-outline"></ion-icon></a>
              </li>
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
              <button type="submit" class="btn-1">Pesquisar</button>
            </form>
          </div>
        </div>
      </nav>
    <form class="col-md-6 offset-md-4" method="post">
        <div class="col-6">
          <label class="form-label">Nome no Cartão</label>
          <input type="text" name="nome" class="form-control" maxlength="225">
        </div>
        <div class="col-md-6">
          <label  class="form-label">Número do cartão</label>
          <input type="text" name="numero_cartao" class="form-control" maxlength="16">
        </div>
        <div class="col-md-6">
          <label class="form-label">CVV</label>
          <input type="text" name="cvv" class="form-control" maxlength="3" >
        </div>
        <div class="col-md-6">
            <label class="form-label">CPF</label>
            <input type="text" name="cpf" class="form-control" maxlength="11" >
          </div>
          <div class="col-md-6">
            <label class="form-label">Data de Vencimento</label>
            <input type="date" name="data_vencimento" class="form-control">
          </div>
        <div class="col-12">
          <button type="submit" class="btn-1">Adicionar Cartão</button>
          <a type="submit" href="suaconta.php" class="btn-1">Voltar</a>
        </div>
      </form>
<?php
 if (isset($_POST['nome'])) {
     $idCliente = $usuario['id'];
     $nome = $_POST['nome'];
     $numero_cartao = $_POST['numero_cartao'];
     $cvv = $_POST['cvv'];
     $data_vencimento = $_POST['data_vencimento'];
     $cpf = $_POST['cpf'];

     // Verificar se está preenchido
     if (!empty($nome) && !empty($numero_cartao) && !empty($cvv) && !empty($data_vencimento) && !empty($cpf)) {
         if ($objUsuario->msgErro == "") { // está tudo certo
             if ($objUsuario->AdicionarCartao($idCliente, $nome, $numero_cartao, $cvv, $data_vencimento, $cpf)) {
                 header("location: suaconta.php");
             } else {
                 echo "Erro ao cadastrar o cartão.";
             }
         }
     } else {
         echo "Erro: Preencha todos os campos!";
     }
 }
?>
</body>
</html>
<?php
} else {
    echo "Usuário não está logado. Redirecionando..."; // ou alguma lógica para redirecionar o usuário
    header("Location: login2.php");
    exit;
}
?>


