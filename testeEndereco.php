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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Teste Endereco</title>
</head>
<body>
<form name="Endereco" method="POST">
  <div class="form-group">
    <label for="inputAddress">Endereço</label>
    <input type="text" name="endereco" class="form-control" id="inputAddress" placeholder="Rua dos Bobos, nº 0">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Cidade</label>
    <input type="text" name="cidade" class="form-control" id="inputAddress2" placeholder="Apartamento, hotel, casa, etc.">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Bairro</label>
      <input type="text" name="bairro" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-4">
      <label for="inputEstado">Estado</label>
      <select name="estado" id="inputEstado" class="form-control">
        <option selected>Escolher...</option>
        <option value="...">...</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputCEP">CEP</label>
      <input type="text" name="cep" class="form-control" id="inputCEP">
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Clique em mim
      </label>
    </div>
  </div>
  <input type="hidden" name="idCliente" value="<?php echo $usuario['id']; ?>">
  <button type="submit" class="btn btn-primary">Entrar</button>
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