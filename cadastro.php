<!DOCTYPE html>
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
    <nav><a class="logo"> <img src="js/img/Tons de Beleza.png" height="36"></a></nav>
    <div class="form-group d-flex justify-content-center"></div>
    <div class="container">
      <form name ="Cadastro" action = "cadastroFORM.php" method = "POST">
        
          <div class="form-group">
              <div class="col-md-6 offset-md-3">
                  <label > Nome</label>
                  <input type="text" name="nome" class="form-control" placeholder="Nome" required>    
              </div>
              <div class="col-md-6 offset-md-3">
                <label > Sobrenome</label>
                <input type="text" name="sobrenome" class="form-control" placeholder="Sobrenome" required>    
            </div> 
            <br>
            <div class="col-md-6 offset-md-3">
              <label > Gênero</label> 
              <select name="genero">
              <option value="feminino"> Feminino</option>
              <option value="masc">Maculino</option>
              <option value="naob"> Não Binário</option>
              <option value="naoinf"> Prefiro não informar</option>
              </select>  
            </div>
            <br>
           <div class="   col-md-6 offset-md-3">
            <label > Data de Nascimento</label>
            <input type="date" name="data_nasc" class="form-control" placeholder="Data de Nascimento" required>    
        </div> <div class="   col-md-6 offset-md-3">
          <label > Email</label>
          <input type="text" name="email" class="form-control" placeholder="Nome@exemplo.com" required>    
      </div>
          </div>
          <div class="form-group">
              <div class="col-md-6 offset-md-3">
                  <label> Senha </label>  
                  <input type="password" name="senha" class="form-control" placeholder="Senha" required>
              </div>
              <br>
              <div class="check">
                <input type="checkbox">
                <label required> Concordo com os termos de uso</label> </div>
              <div class="col-md-6 offset-md-3">
                <button type="submit" class="btn">Cadastrar </button>
                  <script src="cadastro.js"> </script>
          </div>
      </form> 
    </div>
  </div>
  



</body>
