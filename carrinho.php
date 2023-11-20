<?php
require_once '../projetoquartosemestre/classes/usuarios.php';
require_once '../projetoquartosemestre/classes/cart.php';


if (empty($_SESSION)) {
    session_start();
  }
  
  $objUsuario = new Usuario();
  $objUsuario->conectar("cadastro_cliente", "localhost", "root", "admin");
  $usuario = $objUsuario->obterDadosUsuarioLogado();
  $id_cliente = $usuario['id'];
  
  $u = new Cart($pdo);
  if(isset($_COOKIE['user_id'])){
    $id_cliente = $_COOKIE['user_id'];
 }
 
 
 if(isset($_POST['update_cart'])){
 
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    $quantidade = $_POST['quantidade'];
    $quantidade = filter_var($quantidade, FILTER_SANITIZE_STRING);
 
    $update_quantidade = $pdo->prepare("UPDATE `carrinho` SET quantidade = ? WHERE id = ?");
    $update_quantidade->execute([$quantidade, $cart_id]);
 
    $success_msg[] = 'Quantidade do carrinho atualizada!';
 
 }
 
 if(isset($_POST['delete_item'])){
 
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    
    $verify_delete_item = $pdo->prepare("SELECT * FROM `carrinho` WHERE id = ?");
    $verify_delete_item->execute([$cart_id]);
 
    if($verify_delete_item->rowCount() > 0){
       $delete_cart_id = $pdo->prepare("DELETE FROM `carrinho` WHERE id = ?");
       $delete_cart_id->execute([$cart_id]);
       $success_msg[] = 'Item do carrinho deletado!';
    }else{
       $warning_msg[] = 'Item do carrinho já deletado!';
    } 
 
 }
 
 if(isset($_POST['empty_cart'])){
    
    $verify_empty_cart = $pdo->prepare("SELECT * FROM `carrinho` WHERE id_cliente = ?");
    $verify_empty_cart->execute([$usuario['id']]);
 
    if($verify_empty_cart->rowCount() > 0){
       $delete_cart_id = $pdo->prepare("DELETE FROM `carrinho` WHERE id_cliente = ?");
       $delete_cart_id->execute([$usuario['id']]);
       $success_msg[] = 'Carrinho esvaziado!';
    }else{
       $warning_msg[] = 'Carrinho já vazio!';
    } 
 
 }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacola</title>
    <link rel="stylesheet" type="text/css" href="carrinho.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      integrity="sha384-GLhlTQ8i6TqF1fWf5FbOPvfuMz9SBD+qDShO6BPUceIbbVc5UKFvoWigMqujT+"
      crossorigin="anonymous">

</head>

<body>
    <a href="telainicial.html"></a>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="logo"> <img class="logo2" src="https://i.imgur.com/gBQhCJ6.png" height="60"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="cabecalho-item" href="notificacoes.html">Notificações<ion-icon class="icon"
                                                                                                name="notifications-outline"></ion-icon></a>
                    </li>
                    <li class="nav-item">
                        <a class="cabecalho-item" href="telainicial.php">Inicio <ion-icon class="icon"
                                                                                     name="home-outline"></ion-icon></a>
                    </li>
                    <li class="nav-item">
                        <a class="cabecalho-item" href="salvos.html">Salvos <ion-icon class="icon"
                                                                                    name="heart-outline"></ion-icon></a>
                    </li>
                    <li class="nav-item">
                        <a class="cabecalho-item" href="suaconta.php">Minha Conta <ion-icon class="icon"
                                                                                          name="person-outline"></ion-icon></a>
                    </li>
                    <li class="nav-item">
                        <a class="cabecalho-item" href="carrinho.html">Sacola <ion-icon
                                name="bag-handle-outline"></ion-icon></a>
                    </li>
                </ul>
                <form class="d-flex" method="get" role="search" action="resultados_busca.php">
                    <input class="form-control me-2" type="search" name="nome_produto" placeholder="Pesquisar"
                           aria-label="Search">
                    <button type="submit" class="btn-1">Pesquisar</button>
                </form>
            </div>
        </div>
    </nav>

    <section class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-5 mb-sm-6">
                    <div class="card card-style1 border-0">
                        <div class="card-body p-1-9 p-sm-2-3 p-md-6 p-lg-7">
                            <div class="row align-items-center">
                            <div class="col-lg-6 px-xl-10">
        <div class="bg-secondary d-lg-inline-block py-1-9 px-1-9 px-sm-6 mb-1-9 rounded">
            <h3 class="h2 text-white mb-0">Sacola</h3>
        </div>
        <section class="products">

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_cart = $pdo->prepare("SELECT * FROM `carrinho` WHERE id_cliente = ?");
      $select_cart->execute([$id_cliente]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){

         $select_products = $pdo->prepare("SELECT * FROM `produtos` WHERE id = ?");
         $select_products->execute([$fetch_cart['id_produto']]);
         if($select_products->rowCount() > 0){
            $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
      
   ?>
   <form action="" method="POST" class="box">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <img src="<?= $fetch_product['imagem']; ?>" class="image" alt="">
      <div class="text-details">
        <h3 class="name"><?= $fetch_product['nome']; ?></h3>
        <p class="price"><i class="fas fa-indian-rupee-sign"></i> R$<?= $fetch_cart['preco']; ?></p>

      </div>
      <div class="flex">
         <input type="number" name="quantidade" required min="1" value="<?= $fetch_cart['quantidade']; ?>" max="99" maxlength="2" class="quantidade">
         <button type="submit" name="update_cart" class="fas fa-minus"></button>
      </div>
      <p class="sub-total">Subtotal: R$<span><i class="fas fa-indian-rupee-sign"></i> <?= $sub_total = ($fetch_cart['quantidade'] * $fetch_cart['preco']); ?></span></p>
      <input type="submit" value="Deletar" name="delete_item" class="delete-btn" onclick="return confirm('Deletar esse item?');">
   </form>
   <?php
      $grand_total += $sub_total;
      }else{
         echo '<p class="empty">produto não encontrado!</p>';
      }
      }
   }else{
      echo '<p class="empty">seu carrinho está vazio!</p>';
   }
   ?>

   </div>

   <?php if($grand_total != 0){ ?>
      <div class="cart-total">
         <p>Total: R$<span><i class="fas fa-indian-rupee-sign"></i> <?= $grand_total; ?></span></p>
         <form action="" method="POST">
          <input type="submit" value="Esvaziar Carrinho" name="empty_cart" class="delete-btn" onclick="return confirm('Esvaziar o carrinho?');">
         </form>
         <a href="checkout.php" class="btn">Ir para o checkout!</a>
      </div>
   <?php } ?>

</section>
    

                                </div>
                                <ul class="list-unstyled mb-1-9">
                                    <li> <a href="telainicial.php">Continuar Comprando</a> <ion-icon
                                            name="chevron-forward-outline"></ion-icon></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="module"
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI/t1z1lqL9ZDe5zFbKDrwSmPL33pdeFEnHdNxA8="
        crossorigin="anonymous"></script>
</body>

</html>
