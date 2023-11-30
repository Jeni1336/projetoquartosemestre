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

$id_endereco = null;


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

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="checkout.css">
  <link rel="shortcut icon" href="https://i.imgur.com/gBQhCJ6.png" type="x-icon">
  <title>Checkout</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/6c1b2d82eb.js' crossorigin='anonymous'></script>
</head>
<body>
<div class="container montagemCheckout"> 
      <section>
      <div class="column">
        <div class="content">
            <h1>Finalizar Compra</h1>
            </div>
            <div class="checkout-form">
            <h2>Endereço de entrega</h2>
            <?php
            if (count($dadosEndereco) < 3) {

              echo '<button type="submit" class="btn-1" onclick="openPopup(\'overlayEnd\')">Adicionar Endereço</button>';
            }
            ?>
            <div id="overlayEnd" style="display: none;">
            <div id="popup">
        <span class="close-btn" onclick="closePopup('overlayEnd')">&times;</span>
        <h2>Adicionar Endereço</h2>
        
        <form id="formEnd" method="POST" >
          <!-- IDs únicos para os campos do cartão -->
          <label class="form-label">Endereço</label>
          <input type="text" name="endereco" class="form-control" required>
          
          <label class="form-label">Cidade</label>
          <input type="text" name="cidade" class="form-control" required>
          
          <label class="form-label">Bairro</label>
          <input type="text" name="bairro" class="form-control" required>
          
          <label class="form-label"> Estado</label>
          <select name="estado" class="form-select" required>
            <option selected>Estado</option>
            <option>SP</option>
            <option>RJ</option>
            <option>BA</option>
            <option>AM</option>
            <option>PB</option>
          </select>
          
          <label class="form-label">CEP</label>
          <input type="text" name="cep" class="form-control" required>
          
          <button type="submit" name="adicionarNovoEnd">Adicionar Endereço</button>
        </form>
      </div>
    </div>

<form method="post" id="seuFormulario">

<?php
if (!empty($dadosEndereco)) {
    echo '<div class="checkout-form">';
    
    // Itera sobre cada endereço retornado
    foreach ($dadosEndereco as $endereco) {
        echo '<label>';
        // Utiliza o operador de coalescência nula para obter o valor de 'id'
        $enderecoId = isset($endereco['id']) ? $endereco['id'] : '';
        echo '<input type="radio" name="endereco" value="' . $enderecoId . '" onclick="atualizarFormulario(' . $enderecoId . ')" required>';
        //echo '<input type="radio" name="endereco" value="' . $enderecoId . '" onclick="atualizarFormulario(' . $enderecoId . ')" required>';
        echo '<ul>';
        echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Endereço:</span>' . $endereco['endereco'] . '</li>';
        echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Cidade:</span>' . $endereco['cidade'] . '</li>';
        echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Bairro:</span>' . $endereco['bairro'] . '</li>';
        echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Estado:</span>' . $endereco['estado'] . '</li>';
        echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">CEP:</span>' . $endereco['cep'] . '</li>';
        echo '</ul>';
        echo '</label>';
        echo '</br>';
    }

    echo '</div>';
} else {
    echo '<p>Nenhum endereço cadastrado. <a href="endereco.php">Adicionar Endereço</a> <ion-icon name="add-outline"></ion-icon></p>';
}
?>
</form>
<?php
$enderecoIdSelecionado = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verifica se a chave 'enderecoIdSelecionado' está definida no array $_POST
  $enderecoIdSelecionado = isset($_POST['enderecoIdSelecionado']) ? filter_var($_POST['enderecoIdSelecionado'], FILTER_SANITIZE_STRING) : null;

  // Use $enderecoIdSelecionado conforme necessário

  // Atribui o valor da variável $enderecoIdSelecionado a $id_endereco
  $id_endereco = $enderecoIdSelecionado;

}
?>
<?php
if (isset($_POST['adicionarNovoEnd'])) {
  // Obtém os dados do formulário
  $id_cliente = $usuario['id'];
  $endereco = $_POST['endereco'];
  $cidade = $_POST['cidade'];
  $bairro = $_POST['bairro'];
  $estado = $_POST['estado'];
  $cep = $_POST['cep'];

  // Lógica para adicionar o novo endereço
  if (!empty($endereco) && !empty($cidade) && !empty($bairro) && !empty($estado) && !empty($cep)) {
      if ($objUsuario->msgErro == "") { // está tudo certo
          // Certifique-se de que a variável $id_cliente esteja definida
              if ($objUsuario->cadastrarEndereco($id_cliente, $endereco, $cidade, $bairro, $estado, $cep)) {
                  echo '<script>location.reload();</script>';
              } else {
                  echo "Erro ao cadastrar o endereço.";
              }

          }
      } else {
          echo "Erro: " . $objUsuario->msgErro;
      }
  }


?>

            </div>
        </div>
        <div class="column">
  <div class="checkout-form2">
    <form method="post">
    <h2>Forma de Pagamento</h2>
    
    <input type="radio" id="pix" name="forma_de_pagamento" value="pix" required>
    <label for="pix"> Pix</label><br>
    
    <input type="radio" id="boleto" name="forma_de_pagamento" value="boleto" required>
    <label for="boleto"> Boleto</label><br>
    
    <input type="radio" id="cartao" name="forma_de_pagamento" value="cartao" onclick="showCartoes()" required>
   <label for="cartao">Cartão de Crédito</label><br>

   <input type="hidden" name="forma_de_pagamento_hidden" id="forma_de_pagamento_hidden" value="">
   </form>
   <?php
   $opcao_selecionada = null;
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o botão de rádio foi selecionado
    if (isset($_POST['forma_de_pagamento'])) {
        // Cria uma nova variável PHP para armazenar a opção selecionada
        $opcao_selecionada = $_POST['forma_de_pagamento'];
    }
  }
?>

    <div class="cartoes-cadastrados" style="display: none;">

    <?php
    if (!empty($dadosCartao)) {
      echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Nome do Titular:</span>' . $dadosCartao['nome'] . '</li>';
      // Utiliza o operador de coalescência nula para obter o valor de 'numero_cartao'
      $numeroCartao = $dadosCartao['numero_cartao'] ?? '';
      echo '<li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Número Cartão:</span>' . '**** **** **** ' . substr($numeroCartao, -4) . '</li>';
      echo '<form name="cartao" method="POST" id="cartaoForm">
          </form>';
  } else {
      echo '<li>Nenhum cartão cadastrado. <a href="cartao.php">Adicionar Cartão</a> <ion-icon name="add-outline"></ion-icon></li>';
  }
  ?>
</ul>


    <?php
    if (count($dadosCartao) < 1) {
    echo '<button type="submit" class="btn-1" name="adicionar_cartao" id="cartao "onclick="openPopup(\'overlay\')">Adicionar Cartão</button>';
    }
    ?>

      <div id="overlay">
      <div id="popup">
        <span class="close-btn" onclick="closePopup('overlay')">&times;</span>
        <h2>Adicionar Cartão de Crédito</h2>
        
        <form method="POST">
          <!-- IDs únicos para os campos do cartão -->
          <label for="cardHolderName">Nome do Titular:</label>
          <input type="text" id="cardHolderName" name="nome" required><br>
          
          <label for="cardNumber">Número do Cartão:</label>
          <input type="text" id="cardNumber" name="numero_cartao" required maxlength="16"<br>
          
          <label for="cvv">CVV:</label>
          <input type="text" id="cvv" name="cvv" required maxlength="3">
          
          <label for="expiryDate">Data de Validade:</label>
          <input type="date" id="expiryDate" name="data_vencimento" placeholder="MM/AA" required><br>
          <label for="cardCPF">CPF do Titular:</label>
          <input type="text" id="cardCPF" name="cpf" required><br>
          
          <button type="submit">Adicionar Cartão</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
 if (isset($_POST['adicionar_cartao'])) {
    $id_cliente = $usuario['id'];
     $nome = $_POST['nome'];
     $numero_cartao = $_POST['numero_cartao'];
     $cvv = $_POST['cvv'];
     $data_vencimento = $_POST['data_vencimento'];
     $cpf = $_POST['cpf'];

     // Verificar se está preenchido
     if (!empty($nome) && !empty($numero_cartao) && !empty($cvv) && !empty($data_vencimento) && !empty($cpf)) {
         if ($objUsuario->msgErro == "") { // está tudo certo
             if ($objUsuario->AdicionarCartao($idCliente, $nome, $numero_cartao, $cvv, $data_vencimento, $cpf)) {
               echo '<script>location.reload();</script>';
             } else {
                 echo "Erro ao cadastrar o cartão.";
             }
         }
     } else {
         echo "Erro: Preencha todos os campos!";
     }
 }
?>

</div>

<script>
   var radioGroup = document.getElementsByName('forma_de_pagamento');
radioGroup.forEach(function(radio) {
    radio.addEventListener('change', showCartoes);
});
function showCartoes() {
    // Obtém a referência ao elemento com a classe .cartoes-cadastrados
    var cartoesCadastrados = document.querySelector('.cartoes-cadastrados');
  console.log('forma_de_pagamento');
    // Verifica se o botão de Cartão de Crédito está selecionado
    if (document.getElementById('cartao').checked) {
        // Mostra a seção de Cartões Cadastrados
        cartoesCadastrados.style.display = 'block';
        document.getElementById('forma_de_pagamento_hidden').value = "cartao";  // Corrigido para usar getElementById
    } else {
        // Oculta a seção de Cartões Cadastrados
        cartoesCadastrados.style.display = 'none';
    }
}
</script>
<script>
    var radioGroup = document.getElementsByName('forma_de_pagamento');

    radioGroup.forEach(function (radio) {
        radio.addEventListener('change', function () {
            var formaPagamentoHidden = document.getElementById('forma_de_pagamento');
            formaPagamentoHidden.value = radio.value;
        });
    });
</script>



<script>
  function openPopup(param) {
    document.getElementById(param).style.display = 'flex';
  }

  function closePopup(param) {
    document.getElementById(param).style.display = 'none';
  }
</script>

</section>
<section name="item">

 
        <form method="post">
        <div class="container">
        <div class="column">
        <div class="checkout-form3">
          <h2>Itens</h2>
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
               <p class="price"> <?= $fetch_get['preco']; ?> x 1</p>
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
               <p class="price">R$ <?= $fetch_product['preco']; ?> x <?= $fetch_cart['quantidade']; ?></p>
            </div>
         </div>
         <input type="hidden" name="forma_de_pagamento" id="forma_de_pagamento" value="">
         <input type="hidden" name="forma_de_pagamento_hidden" id="forma_de_pagamento_hidden" value="">
        <input type="hidden" name="endereco" value="<?php echo $endereco['id']; ?>">
        <input type="hidden" name="cartao" value="<?php echo isset($id_cartao['id']) ? $id_cartao['id'] : ''; ?>">
        <input type="hidden" name="produto_id[]" value="<?= $fetch_cart['id_produto']; ?>">
        <input type="hidden" name="quantidade[]" value="<?= $fetch_cart['quantidade']; ?>">
  <?php
                  }
               }else{
                  echo '<p class="empty">Seu carrinho está vazio!</p>';
               }
            }

         ?>
         <div class="grand-total"><span>Total:</span><p>R$ <?= $grand_total; ?></p></div>
         <button type="submit" name="fazer_pedido" class="btn-1">Finalizar Compra</button>
         </form>
      </div>

   </div>

</section>


<?php
//var_dump($_POST);
$enderecoIdSelecionado = $id_endereco;
//var_dump($opcao_selecionada);
$forma_de_pagamento = $opcao_selecionada;
//var_dump($_POST['forma_de_pagamento']);
var_dump($id_endereco);
if (isset($_POST['fazer_pedido'])) {

  
  $idCliente = $usuario['id'];
  $forma_de_pagamento = isset($_POST['forma_de_pagamento']) ? filter_var($_POST['forma_de_pagamento'], FILTER_SANITIZE_STRING) : null;
  //$id_endereco = $_POST['enderecoIdSelecionado'];
  //$id_endereco = isset($_POST['enderecoIdSelecionado']) ? $_POST['enderecoIdSelecionado'] : null;
  $id_endereco = isset($_POST['endereco']) ? $_POST['endereco'] : null;
  $produto_ids = isset($_POST['produto_id']) ? $_POST['produto_id'] : array();
  $quantidades = isset($_POST['quantidade']) ? $_POST['quantidade'] : array();


  if (!empty($produto_ids)) {
    // Iterar sobre os itens do carrinho

    foreach ($produto_ids as $index => $produto_id) {
        try {
            // Obter detalhes do produto
            $select_product = $pdo->prepare("SELECT * FROM `produtos` WHERE id = ?");
            $select_product->execute([$produto_id]);
            $produto = $select_product->fetch(PDO::FETCH_ASSOC);

            // Inserir pedido para cada item no carrinho
            $insert_order = $pdo->prepare("INSERT INTO `pedidos` (id_cliente, id_produto, id_endereco, data, preco, quantidade, forma_de_pagamento) VALUES (?, ?, ?, NOW(), ?, ?, ?)");
            $insert_order->execute([$idCliente, $produto_id, $id_endereco, $produto['preco'], $quantidades[$index], $forma_de_pagamento]);
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }
      }

     if ($insert_order) {
        $delete_cart_id = $pdo->prepare("DELETE FROM `carrinho` WHERE id_cliente = ?");
      $delete_cart_id->execute([$id_cliente]);
        ?>
       <script> window.location.href = 'pedidos.php';</script>
        <?php

  }

   } else {
      $warning_msg[] = 'Seu carrinho está vazio!';
   }


?>
</div>
<script>
function atualizarFormulario(enderecoId) {
  document.getElementById('enderecoIdSelecionado').value = enderecoId;
    // Adicionando a linha abaixo, que submeterá o formulário automaticamente quando um endereço for selecionado
   // document.getElementById('seuFormulario').submit();
}

// Obtendo referências aos botões de rádio
var botoesRadio = document.querySelectorAll('input[type="radio"][name="endereco"]');

// Adicionando um ouvinte de eventos a cada botão de rádio
botoesRadio.forEach(function(radio) {
    radio.addEventListener('change', function() {
        // Chamando a função atualizarFormulario quando um botão de rádio for alterado
        atualizarFormulario(this.value);
    });
});


</script>

</body>
</html>
