<?php
if (!isset($_GET['nome_produto'])) {
    header('location: telainicial.php');
    exit;
}

$nome = "%" . trim($_GET['nome_produto']) . "%";

// Corrigindo a string de conexão
$dbh = new PDO('mysql:host=localhost;dbname=cadastro_cliente', 'root', 'admin');

// Corrigindo a query para usar backticks ao redor dos nomes de tabelas e colunas
$sth = $dbh->prepare("SELECT * FROM `produtos` WHERE `nome` LIKE :nome");
$sth->bindParam(':nome', $nome, PDO::PARAM_STR);
$sth->execute();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Busca</title>
    <link rel="shortcut icon" href="https://i.imgur.com/gBQhCJ6.png" type="x-icon">
    <link rel="stylesheet" type="text/css" href="resultados_busca.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/6c1b2d82eb.js' crossorigin='anonymous'></script>
</head>
<style>
  ul{
    display: flex;
    flex-direction: row;
    list-style: none;
    gap: 20px;
    justify-content: center;
    margin: 10px;
}
.icon-car{
    margin: 10px;
}
.link{
    color: #963c54;
}
    
.btn-1{
    background-color: #770624;
    border-radius: 10px;
    color: white;
 }

footer {
     margin: 10px;
     padding: 20px;
     color: black;
}
.icon1{
     margin: 10px;
     display: flexbox;
     flex-direction: row;
     align-items: center;
}
.cabecalho-item-car{
     color: #770624;
}
.btn-1{
     background-color: #770624;
     border-radius: 10px;
     color: white;
}
</style>



<body>
<div class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
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
              <a class="cabecalho-item" href="salvos.php">Salvos <ion-icon class="icon" name="heart-outline"></ion-icon></a>
            </li>
            <li class="nav-item">
              <a class="cabecalho-item" href="suaconta.php">Minha Conta <ion-icon  class="icon" name="person-outline"></ion-icon></a>
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
    </div>
</div>
<?php
if (!isset($_GET['nome_produto'])) {
    header('location: telainicial.php');
    exit;
}

$nome = "%" . trim($_GET['nome_produto']) . "%";

// Conectar ao banco de dados
$conn = new PDO('mysql:host=localhost;dbname=cadastro_cliente', 'root', 'admin');

// Consulta para buscar produtos
$sth = $conn->prepare("SELECT * FROM `produtos` WHERE `nome` LIKE :nome");
$sth->bindParam(':nome', $nome, PDO::PARAM_STR);
$sth->execute();

$resultados = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="resultado-container mx-auto mt-4">
        <?php
        if (empty($resultados)) {
            echo '<p class="text-center">Nenhum resultado encontrado para "' . $_GET['nome_produto'] . '".</p>';
        } else {
            echo '<h2 class="text-center mb-4">Aqui estão os resultados para "' . $_GET['nome_produto'] . '":</h2>';
            echo '<div class="form-group d-flex justify-content-center flex-wrap">';
            foreach ($resultados as $resultado) {
                echo '<div class="resultado-item mx-2 mb-4">';
                echo '<a href="' . $resultado['url_absoluta'] . '">';
                echo '<img src="' . $resultado['imagem'] . '" alt="' . $resultado['nome'] . '" class="img-fluid">';
                echo '</a>';
                echo '<p class="produto-nome text-center mt-2"><a href="' . $resultado['url_absoluta'] . '">' . $resultado['nome'] . '</a></p>';
                echo '<p class="produto-descricao text-center">' . $resultado['descricao'] . '</p>';
                echo '<p class="produto-preco text-center">R$ ' . number_format($resultado['preco'], 2, ',', '.') . '</p>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
        
    </div>
</div>

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

    </footer>
      
    
</body>
</html>

