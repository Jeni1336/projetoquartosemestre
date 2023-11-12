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
    <title>Adicionar Endereço</title>
    <link rel="stylesheet" href="endereco.css">
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
                <a class="cabecalho-item" href="telainicial.html">Inicio <ion-icon class="icon" name="home-outline"></ion-icon>
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
    <form class="row g-3" method="POST">
        <div class="col-6">
          <label class="form-label">Endereço</label>
          <input type="text" name="endereco" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Cidade</label>
          <input type="text" name="cidade" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Bairro</label>
          <input type="text" name="bairro" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label"> Estado</label>
          <select name="estado" class="form-select" required>
            <option selected>Estado</option>
            <option>SP</option>
            <option>RJ</option>
            <option>BA</option>
            <option>AM</option>
            <option>PB</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">CEP</label>
          <input type="text" name="cep" class="form-control" required>
        </div>
        <input type="hidden" name="idCliente" value="<?php echo $usuario['id']; ?>">
        <div class="col-12">  
        <button type="submit" class="btn-1">Adicionar Endereço</button>
          <a href="suaconta.php" type="submit" class="btn-1">Voltar</a>
        </div>
      </form>

      <?php
if (isset($_POST['endereco'])) {
  $idCliente = $usuario['id'];
  $endereco = $_POST['endereco'];
  $cidade = $_POST['cidade'];
  $bairro = $_POST['bairro'];
  $estado = $_POST['estado'];
  $cep = $_POST['cep'];

  // Verificar se está preenchido
  if (!empty($endereco) && !empty($cidade) && !empty($bairro) && !empty($estado) && !empty($cep)) {
      if ($objUsuario->msgErro == "") { // está tudo certo
          if ($objUsuario->cadastrarEndereco($idCliente, $endereco, $cidade, $bairro, $estado, $cep)) {
            
              header("location: suaconta.php");
          } else {
              echo "Erro ao cadastrar o endereço.";
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

