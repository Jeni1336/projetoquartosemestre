<?php
if (isset($_GET['mensagem_sucesso'])) {
  $mensagemSucesso = urldecode($_GET['mensagem_sucesso']);
  echo "<script>alert('$mensagemSucesso');</script>";
}  
?>

<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Tons de Beleza</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="files/icon.png">
    <link rel="stylesheet" type="text/css" href="inicio.css">
    <link rel="shortcut icon" href="https://i.imgur.com/gBQhCJ6.png" type="x-icon">

    <!-- Chatbot -->
    <link rel="stylesheet" href="../projetoquartosemestre/chatbot/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap CSS -->
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
          <a class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Minha Conta </a>
          <ul class="dropdown-menu">
            <li><a class="cabecalho-item" href="#">Cadastra-se</a></li>
            <li><a class="cabecalho-item" href="#">Login</a></li>
            <li><a class="cabecalho-item" href="#">Sair da conta </a></li>
          </ul>
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
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="https://i.imgur.com/nc5dc1N.jpg" class="d-block w-100" alt="foto">
                  </div>
                  <div class="carousel-item">
                    <img src="https://i.imgur.com/8H1kicp.jpg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="https://i.imgur.com/39rOr9o.jpg" class="d-block w-100" alt="...">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>

                  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                    <div class="carousel-indicators">
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>

                    <h3> Ofertas e Promoções</h3>
                    <header class="presentation">
                      <div class="mid">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="card wow  zoomIn animated" style="visibility: visible; animation-name: zoomIn; align-items: center;"> <img src="https://i.imgur.com/vio01Yo.jpg" class="img-fluid">
                              <br>
                              <h5 class="card-title">Sérum</h5 > 
                              <p class="card-text">R$ 50,00</p>
                              <a href="serumprod.php" class="btn btn-primary">Saiba mais</a> 
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="card wow  zoomIn animated" style="visibility: visible; animation-name: zoomIn; align-items: center;"> <img src="https://i.imgur.com/KoReX3t.jpg" class="img-fluid">
                              <br>
                              <h5 class="card-title">Batom</h5 > 
                                <p class="card-text">R$ 30,00</p>
                                <a href="batom.php" class="btn btn-primary">Saiba mais</a>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="card wow  zoomIn animated" style="visibility: visible; animation-name: zoomIn; align-items: center;"> <img src="https://i.imgur.com/huG12VB.jpg" class="img-fluid">
                              <br>
                              <h5 class="card-titlee">Kit de Maquiagem</h5 > 
                                <p class="card-textt">R$ 70,00</p>
                                <a href="maquiagem.php" class="btn btn-primary">Saiba mais</a>
                          </div>
                      </div>
                      <div class="col-md-3">
                        <div class="card wow  zoomIn animated" style="visibility: visible; zoomIn; align-items: center;"> <img src="https://i.imgur.com/qAMdoeP.jpg" class="img-fluid">
                            <br>
                            <h5 class="card-titlee">Máscara de Cílios</h5 > 
                              <p class="card-textt">R$ 35,00</p>
                              <a href="cilios.php" class="btn btn-primary">Saiba mais</a>
                        </div>
                    </div>
                  </div>
             
              <img class="bannerprod" src="https://i.imgur.com/sL8odLW.jpg" class="img-fluid" alt="..." style="margin-top: 50px;">
                            
                
                  
            
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

      
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
      
      
    </footer>
    <div id="closeChatbot" style="display: none; position: fixed; bottom: 400px; right: 30px; z-index: 1000;">
    <img src="../projetoquartosemestre/images/botao-fechar.png" alt="Fechar Chatbot" style="width: 80px;">
</div>

    <div id="chatbotContainer" style="display: none;">

    <!-------<div id="chatbotContainer" style="display:none;">-->
    <?php
    include('../projetoquartosemestre/chatbot/bot.php');
    
    $conn = mysqli_connect("localhost", "root", "admin", "cadastro_cliente") or die("Database Error");
    $getMesg = isset($_POST['text']) ? mysqli_real_escape_string($conn, $_POST['text']) : "";

    ?>
        </div>

<div id="openChatbotContainer">
    <img id="openChatbot" src="../projetoquartosemestre/images/botao-bot.png" alt="Abrir Chatbot">
</div>

</div>
</div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
    
    <script>
        function scrollToBottom() {
            $(".form").scrollTop($(".form")[0].scrollHeight);
        }

        $(document).ready(function(){
            $("#openChatbot").on("click", function(){
                $("#chatbotContainer").show();
                $("#openChatbot").hide();
                $("#closeChatbot").show();
                scrollToBottom();
            });

            $("#closeChatbot").on("click", function(){
                $("#chatbotContainer").hide();
                $("#openChatbot").show();
                $("#closeChatbot").hide();
            });
        });
    </script>
</body>
</html>