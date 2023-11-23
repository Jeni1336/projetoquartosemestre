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


if (isset($_GET['id'])) {
  $idEndereco = $_GET['id'];
  $endereco = $objUsuario->SelectMultiplosEnderecos($idEndereco);
} 


if ($usuario) { 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Endereço</title>
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
          <form class="d-flex" method="get" role="search" action="resultados_busca.php">
            <input class="form-control me-2" type="search" name="nome_produto" placeholder="Pesquisar" aria-label="Search">
            <button type="submit" class="btn-1">Pesquisar</button>
          </form>
        </div>
      </div>
    </nav>
    <form class="row g-3" method="POST">
        <div class="col-6">
          <label class="form-label">Endereço</label>
          <input type="text" name="endereco" class="form-control" required value="<?php echo $endereco['endereco']; ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label">Cidade</label>
          <input type="text" name="cidade" class="form-control" required value="<?php echo $endereco['cidade']; ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label">Bairro</label>
          <input type="text" name="bairro" class="form-control" required value="<?php echo $endereco['bairro']; ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label"> Estado</label>
          <select name="estado" class="form-select" required>
            <option selected>Estado</option>
            <option value="SP" <?php echo ($endereco['estado'] == 'SP') ? 'selected' : ''; ?>>SP</option>
            <option value="RJ" <?php echo ($endereco['estado'] == 'RJ') ? 'selected' : ''; ?>>RJ</option>
            <option value="BA" <?php echo ($endereco['estado'] == 'BA') ? 'selected' : ''; ?>>BA</option>
            <option value="AM" <?php echo ($endereco['estado'] == 'AM') ? 'selected' : ''; ?>>AM</option>
            <option value="PB" <?php echo ($endereco['estado'] == 'PB') ? 'selected' : ''; ?>>PB</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">CEP</label>
          <input type="text" name="cep" class="form-control" required value="<?php echo $endereco['cep']; ?>">
        </div>
        <input type="hidden" name="idEndereco" value="<?php echo $endereco['id']; ?>">
        <div class="col-12">  
        <button type="submit" class="btn-1">Editar Endereço</button>
          <a href="suaconta.php" type="submit" class="btn-1">Voltar</a>
        </div>
      </form>

      <?php
if (isset($_POST['endereco'])) {
  $endereco = $_POST['endereco'];
  $cidade = $_POST['cidade'];
  $bairro = $_POST['bairro'];
  $estado = $_POST['estado'];
  $cep = $_POST['cep'];

  // Verificar se está preenchido
  if (!empty($endereco) && !empty($cidade) && !empty($bairro) && !empty($estado) && !empty($cep)) {
    if ($objUsuario->msgErro == "") {
        if ($objUsuario->EditarEndereco($idEndereco, $endereco, $cidade, $bairro, $estado, $cep)) {
            header("location: suaconta.php");
            exit();
        } else {
            echo "Erro ao editar o endereço.";
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

