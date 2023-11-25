<?php
require_once '../projetoquartosemestre/classes/usuarios.php';
require_once '../projetoquartosemestre/classes/cart.php';

if (empty($_SESSION)) {
  session_start();
}

$objUsuario = new Usuario();
$objUsuario->conectar("cadastro_cliente", "localhost", "root", "admin");
$usuario = $objUsuario->obterDadosUsuarioLogado();

$u = new Cart($pdo);


?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blush</title>
    <link rel="stylesheet" type="text/css" href="blush.css">
    <link rel="shortcut icon" href="https://i.imgur.com/gBQhCJ6.png" type="x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/6c1b2d82eb.js' crossorigin='anonymous'></script>
    </head>
    <body>
    <div class="caixinha"> </div>
    <!-- <div class="cont">
      <img  src="img/20231025_faixa_topo_desk.avif" alt="banner">
    </div>  --->
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
  
              <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                
                <ul>
                  <hr>
                  <li class="prod">
                    <a class="link" href="#"> Kit de Maquiagens </a>
                  </li>
                  <li class="prod"> 
                    <a class="link" href="# ">Paletas</a>
                  </li>
                  <li class="prod">
                    <a class="link" href="#"> Rosto</a>
                  </li>
                  <li class="prod"> 
                    <a class="link" href="# ">Olhos</a>
                  </li>
                  <li class="prod"> 
                    <a class="link" href="# ">Sobrancelhas</a>
                  </li>
                  <li class="prod">
                    <a class="link" href="# ">Boca</a>
                  </li>
                  <li class="prod">
                    <a class="link" href="# ">Pincéis</a>
                  </li>
                  <li class="prod">
                    <a class="link" href="# ">Skin Care</a>
                  </li>
                  <li class="prod">
                    <a class="link" href="# ">Só na TB</a>
                  </li>
                  <li class="prod">
                    <a class="link" href="# ">Ofertas</a>
                  </li>
                </ul>
                <div class="produto-container">
                  <img src="" alt="Produto">
                  <div class="descricao-produto">
                      <h2>Blush</h2>
                      <p> Blush</p>
                      <p>R$ 35,00</p>
                      <form method="post">
   <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <a href="salvos.html" style="text-decoration: none; color:rgb(121, 28, 28)">
         Adicionar aos Salvos <ion-icon name="heart-outline"></ion-icon>
      </a>
      <input type="number" name="quantidade" value="1" min="1"> <!-- Campo de entrada da quantidade -->
      <button name="add_to_cart" class="btn-2 me-md-2" type="submit">Adicionar à Sacola</button>
      <input type="hidden" name="id_produto" value="2"> <!-- Defina o ID do sérum aqui -->
   </div>
   Avaliações
   <ion-icon name="star"></ion-icon>
   <ion-icon name="star"></ion-icon>
   <ion-icon name="star"></ion-icon>
   <ion-icon name="star"></ion-icon>
   <ion-icon name="star"></ion-icon>
</form>

</div>

 </div>
<?php
 if (isset($_POST['add_to_cart'])) {
  if ($usuario && isset($usuario['id'])) {
      $id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_STRING);
      $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_STRING);
      $id_cliente = $usuario['id'];

      $resultado = $u->adicionarAoCarrinho($pdo, $id_cliente, $id_produto, $quantidade);
      echo $resultado;
  } else {
      echo "Erro: ID do cliente não encontrado. Usuário: " . print_r($usuario, true);
  }
}

?>

<div class="feedback"> 
  <ion-icon name="star"></ion-icon>
  <ion-icon name="star"></ion-icon>
  <ion-icon name="star"></ion-icon>
  <ion-icon name="star"></ion-icon>
  <ion-icon name="star"></ion-icon>
</div>
<a style="color:#770624;" href="avaliacoes.php"> <h2 style="color: #770624;"> Avaliar Produto</h2></a>
  
               <footer>
                <div class="card text-center">
                  <div class="card-header">
                    Tons de Beleza
                  </div>
                  <div class="card-body">
                    <ul>
                      <li class="prod1" > 
                        <a class="link" href="sobre.html">Sobre</a>
                      </li>
                      <li class="prod1"> 
                        <a class="link" href="contato.html">Contato</a>
                      </li>
                      <li class="prod1"> 
                        <a class="link" href="trabalheconosco.html">Trabalhe Conosco</a>
                      </li>
                    </ul>
                  </div>
                  <div class="icon1">
                  <ion-icon class="icon1" name="logo-instagram"> instagram</ion-icon>
                  <ion-icon class="icon1" name="logo-twitter">x</ion-icon>
                  <ion-icon class="icon1" name="logo-tiktok">tik tok</ion-icon>
                </div>
             <p>
              Na Tons de Beleza, acreditamos que a maquiagem é uma forma de expressão, é pra quem quiser pra quem sonha, quem tem luta e quem tem fé, e pra quem tem empoderamento. Oferecemos uma ampla gama de produtos de beleza de alta qualidade para realçar sua beleza única. Nossa missão é ajudar você a se sentir confiante e deslumbrante todos os dias.
             </p>
                </div>
                
                
              </footer>
           

               <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
              <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
</body>
</html>