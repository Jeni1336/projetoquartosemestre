<?php
require_once '../projetoquartosemestre/classes/usuarios.php';
$u = new Usuario;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="login2.css">
</head>
<body>
  <div class="caixa">
  <nav><a class="logo"> <img src="https://i.imgur.com/gBQhCJ6.png" height="60"></a></nav>
  <div class="form-group d-flex justify-content-center"></div>
  <div class="container">
    <form method ="POST"> 
        <div class="form-group">
            <div class="col-md-6 offset-md-3">
                <label > Email</label>
                  <input type="text" name="email" class="form-control" placeholder="Nome@exemplo.com" required>
            </div>
            <div class="form-group">
            <div class="col-md-6 offset-md-3">
              <label> Senha </label>  
                <input type="password" name="senha" class="form-control" placeholder="Senha" required>
            </div>      
        <div class="form-group">
            <div class="col-md-6 offset-md-3">
              <button type="submit" class="btn">Login</button>
            </div>
        </div>
    </form> 
</div>
</div>
<a class="linkcad" href="cadastro.php"> Não possui conta? Cadastra-se agora</a>

<?php
if(isset($_POST['email'])){
  $email = ($_POST ['email']);
  $senha = ($_POST ['senha']);
  
  if(!empty($email) && !empty($senha)){
    $u-> conectar( "cadastro_cliente", "localhost", "root", "admin");
    if ($u -> msgErro == ""){
    if($u->logar($email, $senha)){
      header("location: suaconta.php");

    }else{
      
        echo "Email e/ou senha estão incorretos!";

    }
  } else{

      echo "Erro: ".$u ->msgErro;

  }

  }else{
    echo "Preencha todos os campos";
  }
}

?>

</body>
</html>
