<!DOCTYPE html>
<?php
  require_once '../projetoquartosemestre/classes/usuarios.php';
  $u = new Usuario();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Cadastro</title>
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
                  <input type="text" name="nome" class="form-control" placeholder="Nome" maxlength="30" required>    
              </div>
              <div class="col-md-6 offset-md-3">
                <label > Sobrenome</label>
                <input type="text" name="sobrenome" class="form-control" placeholder="Sobrenome" maxlength="30" required>    
            </div> 
            <br>
            <div class="col-md-6 offset-md-3">
              <label > Gênero</label> 
              <select name="genero">
              <option value="feminino"> Feminino</option>
              <option value="masc">Masculino</option>
              <option value="naob"> Não Binário</option>
              <option value="naoinf"> Prefiro não informar</option>
              </select>  
            </div>
            <br>
           <div class="   col-md-6 offset-md-3">
            <label > Data de Nascimento</label>
            <input type="date" name="data_nasc" class="form-control" placeholder="Data de Nascimento" maxlength="10" required>    
        </div> <div class="   col-md-6 offset-md-3">
          <label > Email</label>
          <input type="text" name="email" class="form-control" placeholder="Nome@exemplo.com" maxlength="30" required>    
      </div>
          </div>
          <div class="form-group">
              <div class="col-md-6 offset-md-3">
                  <label> Senha </label>  
                  <input type="password" name="senha" class="form-control" placeholder="Senha" maxlength="32" required>
              </div>
              <div class="col-md-6 offset-md-3">
                  <label> Confirmar Senha </label>  
                  <input type="password" name="confirmar_senha" class="form-control" placeholder="Senha" maxlength="32" required>
              </div>
              <br>
              <div class="check">
                <input type="checkbox">
                <a class="termos" href="termos.html" required>Concordo com os termos de uso</a></div>
              <div class="col-md-6 offset-md-3">
                <button type="submit" class="btn" >Cadastrar </button>
                  
          </div>
      </form> 
    </div>
  </div>
  <?php
//verificar se clicou no botao
if(isset($_POST['nome'])){
$nome = ($_POST ['nome']);
$sobrenome = ($_POST ['sobrenome']);
$genero = ($_POST ['genero']);
$data_nasc = ($_POST ['data_nasc']);
$email = ($_POST ['email']);
$senha = ($_POST ['senha']);
$confirmar_senha = ($_POST ['confirmar_senha']);
//verificar se esta preenchido
if(!empty($nome) && !empty($sobrenome) && !empty($genero) && !empty($data_nasc) && !empty($email) && !empty($senha)){
  $u-> conectar( "cadastro_cliente", "localhost", "root", "admin");
if($u -> msgErro == "")//esta tudo certo 
  {
    if($senha === $confirmar_senha){
    if($u -> cadastrar($nome, $sobrenome, $genero, $data_nasc, $email, $senha)){
    
      header("location: telainicial.html");
    }else{
      ?>
    msgErro();
      <?php
    }
  
    }
  }
  else{
    echo"Erro: ".$u->msgErro;
  }
}
else{
  echo "Preencha todos os campos!";
}
}

?>

<script src="../projetoquartosemestre/cadastro1.js"> </script>

</body>
</html>
