<?php
require_once '../projetoquartosemestre/classes/usuarios.php';
require_once '../projetoquartosemestre/classes/cart.php';

if (empty($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header("location: login2.php");
    exit;
}
$idEspecifico = 34;

$objUsuario = new Usuario();
$objUsuario->conectar("cadastro_cliente", "localhost", "root", "admin");

$usuario = $objUsuario->obterDadosUsuarioLogado();

$dadosEndereco = $objUsuario->SelectEndereco($usuario['id']);
$id_cliente = $usuario['id'];

$u = new Cart($pdo);
if (isset($_COOKIE['user_id'])) {
    $id_cliente = $_COOKIE['user_id'];
}

$dadosCartao = $objUsuario->SelectCartao($usuario['id']); // Adicionado novamente


 

  if(isset($_POST['cancel'])){

    $update_orders = $pdo->prepare("UPDATE `pedidos` SET status = ? WHERE id = ?");
    $update_orders->execute(['cancelado', $order['id']]);
    header('location:pedidos.php');
 
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="files/icon.png">
    <link rel="stylesheet" type="text/css" href="pedidos.css">
    <link rel="shortcut icon" href="https://i.imgur.com/gBQhCJ6.png" type="x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/6c1b2d82eb.js' crossorigin='anonymous'></script>
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

<section class="order-details">

<h1 class="heading">Detalhes dos Pedidos</h1>

<div class="box-container">

<?php
$select_all_orders = $pdo->prepare("SELECT * FROM `pedidos`");
$select_all_orders->execute();
$all_orders = $select_all_orders->fetchAll(PDO::FETCH_ASSOC);

foreach ($all_orders as $order) {
    $order_id = $order['id'];
    $grand_total = 0;
    $sub_total = ($order['preco'] * $order['quantidade']);
    $grand_total += $sub_total;

    // Use $order conforme necessário
    $select_product = $pdo->prepare("SELECT * FROM `produtos` WHERE id = ? LIMIT 1");
    $select_product->execute([$order['id_produto']]);
    
    if ($select_product->rowCount() > 0) {
        $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);

        // Exibir informações do produto e do pedido
        echo '<div class="box">';
        echo '<div class="col">';
        echo '<p class="title"><i class="fas fa-calendar"></i>' . $order['data'] . '</p>';
        echo '<img src="' . $fetch_product['imagem'] . '" class="image" alt="">';
        echo '<p class="price">R$ ' . $order['preco'] . ' x ' . $order['quantidade'] . '</p>';
        echo '<h3 class="name">' . $fetch_product['nome'] . '</h3>';
        echo '<p class="grand-total">Total: R$<span><i class="fas fa-indian-rupee-sign"></i> ' . $grand_total . '</span></p>';
        echo '</div>';

    
?>
<!--<div class="box">-->
   <div class="col">
      <p class="title"><i class="fas fa-calendar"></i><?= $order['data']; ?></p>
      <img src="<?= $fetch_product['imagem']; ?>" class="image" alt="">
      <p class="price"> R$<?= $order['preco']; ?> x <?= $order['quantidade']; ?></p>
      <h3 class="name"><?= $fetch_product['nome']; ?></h3>
      <p class="grand-total">Total: R$<span><i class="fas fa-indian-rupee-sign"></i> <?= $grand_total; ?></span></p>
 


  
  <div class="col">
  <h3 class="title">Endereço de Entrega</h3>
  <ul class="list-unstyled mb-1-9">
    <li class="mb-2 display-28">
   <span class="display-26 text-secondary me-2 font-weight-600">Nome:</span>
   <?php echo $usuario['nome'] . " " . $usuario['sobrenome']; ?>
   </li>
        <li class="mb-2 display-28">
            <span class="display-26 text-secondary me-2 font-weight-600">Email:</span>
            <?php echo $usuario['email']; ?>
        </li>
        <?php
        $select_address = $pdo->prepare("
            SELECT endereco.*, pedidos.id as pedido_id
            FROM endereco
            JOIN pedidos ON endereco.id = pedidos.id_endereco
            WHERE pedidos.id = ?
        ");
        $select_address->execute([$order_id]);
        $endereco = $select_address->fetch(PDO::FETCH_ASSOC);

        if ($endereco) {
            ?>
            <li class="mb-2 display-28">
                <span class="display-26 text-secondary me-2 font-weight-600">Endereço:</span>
                <?php echo $endereco['endereco']; ?>
            </li>
            <li class="mb-2 display-28">
                <span class="display-26 text-secondary me-2 font-weight-600">Cidade:</span>
                <?php echo $endereco['cidade']; ?>
            </li>
            <li class="mb-2 display-28">
                <span class="display-26 text-secondary me-2 font-weight-600">Bairro:</span>
                <?php echo $endereco['bairro']; ?>
            </li>
            <li class="mb-2 display-28">
                <span class="display-26 text-secondary me-2 font-weight-600">Estado:</span>
                <?php echo $endereco['estado']; ?>
            </li>
            <li class="mb-2 display-28">
                <span class="display-26 text-secondary me-2 font-weight-600">CEP:</span>
                <?php echo $endereco['cep']; ?>
            </li>
            <?php
        } else {
            echo '<li class="mb-2 display-28">Endereço não encontrado.</li>';
        }
        ?>
    </ul>
</div>
<?php
echo '<p class="title">Status</p>';
echo '<p class="status" style="color:';
if ($order['status'] == 'delivered') {
    echo 'green';
} elseif ($order['status'] == 'canceled') {
    echo 'red';
} else {
    echo 'orange';
}
echo '">' . $order['status'] . '</p>';

if ($order['status'] == 'canceled') {
    echo '<a href="checkout.php?get_id=' . $fetch_product['id'] . '" class="btn">Pedir Novamente</a>';
} else {
    //echo '<form action="" method="POST">';
   // echo '<input type="submit" value="Cancelar Pedido" name="cancel" class="delete-btn" onclick="return confirm(\'Cancelar esse pedido?\');">';
  //  echo '</form>';
}
echo '</div>';
echo '</div>';
}
} 

?>
</div>
</div>

</section>
</body>
</html>