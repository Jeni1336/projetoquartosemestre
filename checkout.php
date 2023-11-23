<?php
require_once '../projetoquartosemestre/classes/usuarios.php';
require_once '../projetoquartosemestre/classes/cart.php';


if (empty($_SESSION)) {
    session_start();
  }
if(!isset($_SESSION['id'])){
  header("location: login2.php"); 
  exit;
  }

  $objUsuario = new Usuario();
  $objUsuario->conectar("cadastro_cliente", "localhost", "root", "admin");
  $usuario = $objUsuario->obterDadosUsuarioLogado();
  $dadosEndereco = $objUsuario->SelectEndereco($usuario['id']);
  $dadosCartao = $objUsuario->SelectCartao($usuario['id']);
  $id_cliente = $usuario['id'];
  
  $u = new Cart($pdo);
  if(isset($_COOKIE['user_id'])){
    $id_cliente = $_COOKIE['user_id'];
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


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/6c1b2d82eb.js' crossorigin='anonymous'></script>
</head>
<body>
<!-- Seção de Informações de Endereço -->
<section class="bg-light">
    <div class="container">
        <form method="post">
            <h3 class="h2 text-white mb-0">Endereço de Entrega</h3>
            
            <!-- Opções de endereço carregadas dinamicamente do banco de dados -->
            <?php
            if (!empty($dadosEndereco)) {
                echo '<ul>';
                echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Endereço:</span>' . $dadosEndereco['endereco'] . '</li>';
                echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Cidade:</span>' . $dadosEndereco['cidade'] . '</li>';
                echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Bairro:</span>' . $dadosEndereco['bairro'] . '</li>';
                echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Estado:</span>' . $dadosEndereco['estado'] . '</li>';
                echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">CEP:</span>' . $dadosEndereco['cep'] . '</li>';
                echo '</ul>';
            } else {
                echo '<p>Nenhum endereço cadastrado. <a href="endereco.php">Adicionar Endereço</a> <ion-icon name="add-outline"></ion-icon></p>';
            }
            ?>
            
            <!-- Botões de rádio -->
            <?php
            foreach ($arrayDeEnderecosDoUsuario as $endereco) {
                echo "<label><input type='radio' name='endereco' value='{$endereco['id']}' required> {$endereco['endereco']}</label><br>";
            }
            ?>
            
            <button type="submit" class="btn-1">Continuar</button>
        </form>
    </div>
</section>




<!-- Seção de Itens -->
<section class="bg-light">
      <div class="summary">
         <h3 class="title">Itens do Carrinho</h3>
         <?php
            $grand_total = 0;
            if(isset($_GET['get_id'])){
               $select_get = $pdo->prepare("SELECT * FROM `produtos` WHERE id = ?");
               $select_get->execute([$_GET['get_id']]);
               while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
         ?>
         <div class="flex">
         <img src="<?= $fetch_product['imagem']; ?>" class="image" alt="">
            <div>
               <h3 class="name"><?= $fetch_get['nome']; ?></h3>
               <p class="price"><i class="fas fa-indian-rupee-sign"></i> <?= $fetch_get['preco']; ?> x 1</p>
            </div>
         </div>
         <?php
               }
            }else{
              $select_cart = $pdo->prepare("SELECT * FROM `carrinho` WHERE id_cliente = ?");
               $select_cart->execute([$id_cliente]);
               if($select_cart->rowCount() > 0){
                  while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                     $select_products = $pdo->prepare("SELECT * FROM `produtos` WHERE id = ?");
                     $select_products->execute([$fetch_cart['id_produto']]);
                     $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                     $sub_total = ($fetch_cart['quantidade'] * $fetch_product['preco']);

                     $grand_total += $sub_total;
            
         ?>
         <div class="flex">
         <img src="<?= $fetch_product['imagem']; ?>" class="image" alt="">
            <div>
               <h3 class="name"><?= $fetch_product['nome']; ?></h3>
               <p class="price"><i class="fas fa-indian-rupee-sign"></i> <?= $fetch_product['preco']; ?> x <?= $fetch_cart['quantidade']; ?></p>
            </div>
         </div>
         <?php
                  }
               }else{
                  echo '<p class="empty">Seu carrinho está vazio!</p>';
               }
            }
         ?>
         <div class="grand-total"><span>grand total :</span><p><i class="fas fa-indian-rupee-sign"></i> <?= $grand_total; ?></p></div>
      </div>

   </div>

</section>


</body>
</html>