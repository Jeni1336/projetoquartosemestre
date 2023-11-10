<?php
require_once '../projetoquartosemestre/classes/usuarios.php';

session_start();
if(!isset($_SESSION['id'])){
  header("location: login2.php"); 
  exit;
}

$objUsuario = new Usuario();
$objUsuario-> conectar( "cadastro_cliente", "localhost", "root", "admin");

$usuario = $objUsuario->obterDadosUsuarioLogado();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Editar</title>
    <link rel="stylesheet" type="text/css" href="cadastro.css">
</head>
<body>
    <div class="caixa">
    <nav><a class="logo"> <img src="../projetoquartosemestre/images/Logo-Bonito.png" height="60"></a></nav>
    <div class="form-group d-flex justify-content-center"></div>
    <div class="container">
      <form name ="Cadastro" onsubmit="confereSenha2();" method ="POST">
        
          <div class="form-group">
              <div class="col-md-6 offset-md-3">
                  <label > Nome</label>
                  <input type="text" name="nome" class="form-control" placeholder="Nome" maxlength="30" required value="<?php echo $usuario['nome']; ?>">    
              </div>
              <div class="col-md-6 offset-md-3">
                <label > Sobrenome</label>
                <input type="text" name="sobrenome" class="form-control" placeholder="Sobrenome" maxlength="30" required value="<?php echo $usuario['sobrenome']; ?>">    
            </div> 
            <br>
            <div class="col-md-6 offset-md-3">
              <label > Gênero</label> 
              <select name="genero">
                    <option value="feminino" <?php echo ($usuario['genero'] == 'feminino') ? 'selected' : ''; ?>>Feminino</option>
                    <option value="masc" <?php echo ($usuario['genero'] == 'masc') ? 'selected' : ''; ?>>Masculino</option>
                    <option value="naob" <?php echo ($usuario['genero'] == 'naob') ? 'selected' : ''; ?>>Não Binário</option>
                    <option value="naoinf" <?php echo ($usuario['genero'] == 'naoinf') ? 'selected' : ''; ?>>Prefiro não informar</option>
              </select>  
            </div>
            <br>
           <div class="   col-md-6 offset-md-3">
            <label > Data de Nascimento</label>
            <input type="date" name="data_nasc" class="form-control" placeholder="Data de Nascimento" maxlength="10" required value="<?php echo $usuario['data_nasc']; ?>">    
        </div> <div class="   col-md-6 offset-md-3">
          <label > Email</label>
          <input type="text" name="email" class="form-control" placeholder="Nome@exemplo.com" maxlength="30" required value="<?php echo $usuario['email']; ?>">    
      </div>
          </div>
          <div class="form-group">
              <div class="col-md-6 offset-md-3">
                  <label> Nova Senha </label>  
                  <input type="password" name="senha" class="form-control" placeholder="Senha" maxlength="32" required>
              </div>
              <div class="col-md-6 offset-md-3">
                  <label> Confirmar Senha </label>  
                  <input type="password" name="confirmar_senha" class="form-control" placeholder="Senha" maxlength="32" required>
              </div>
              <br>
              
                <button type="submit" class="btn"> Alterar </button>
                <a type="button" class="btn" href="../projetoquartosemestre/suaconta.php"> Cancelar </a>
                  
          </div>
      </form> 
    </div>
  </div>
<?php

if(isset($_POST['nome'])){
$nome = ($_POST ['nome']);
$sobrenome = ($_POST ['sobrenome']);
$genero = ($_POST ['genero']);
$data_nasc = ($_POST ['data_nasc']);
$email = ($_POST ['email']);
$senha = ($_POST ['senha']);
$confirmar_senha = ($_POST ['confirmar_senha']);
//obter o id
$idUsuario = $usuario['id'];
//verificar se esta preenchido
if(!empty($nome) && !empty($sobrenome) && !empty($genero) && !empty($data_nasc) && !empty($email) && !empty($senha)){
$objUsuario-> conectar( "cadastro_cliente", "localhost", "root", "admin");
if($objUsuario -> msgErro == "")//esta tudo certo 
  {
    //$idUsuario = $_SESSION['id']; // Adicione esta linha para obter o ID do usuário da sessão
    if ($objUsuario->editar($idUsuario, $nome, $sobrenome, $genero, $data_nasc, $email, $senha)) {
      header("Location: suaconta.php");
      exit();
  } else {
      echo "Erro ao editar o usuário.";
  }
}
  }
  else{
    echo"Erro: ".$objUsuario->msgErro;
  }
}
?>
<script src="../projetoquartosemestre/cadastro1.js"> </script>