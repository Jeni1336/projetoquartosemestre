<?php
// carrinho.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../projetoquartosemestre/classes/usuarios.php';
require_once '../projetoquartosemestre/classes/cart.php';

// Inicia a sessão
if (empty($_SESSION)) {
    session_start();
}

// Define your PDO connection parameters
$host = "localhost";
$dbname = "cadastro_cliente";
$user = "root";
$pass = "admin";

// Attempt to create a PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Cria uma instância da classe Cart passando o objeto PDO
$carrinho = new Cart($pdo);

// Verifica se a ação de adicionar ao carrinho está presente
if (isset($_GET['add_to_cart'])) {
    // Obtém o ID do produto
    $produtoId = $_GET['add_to_cart'];

    // Adiciona o produto ao carrinho
    $carrinho->addToCart($produtoId, 1); // 1 representa a quantidade, você pode ajustar conforme necessário
}

// Redireciona para onde você desejar após a adição ao carrinho
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacola</title>
    <link rel="stylesheet" type="text/css" href="suaconta.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                <div class="col-lg-12 mb-4 mb-sm-5">
                    <div class="card card-style1 border-0">
                        <div class="card-body p-1-9 p-sm-2-3 p-md-6 p-lg-7">
                            <div class="row align-items-center">
                            <div class="col-lg-6 px-xl-10">
        <div class="bg-secondary d-lg-inline-block py-1-9 px-1-9 px-sm-6 mb-1-9 rounded">
            <h3 class="h2 text-white mb-0">Sacola</h3>
        </div>
        <?php
        $cartContent = $carrinho->getCart(); // Corrigido para usar $carrinho

        if (empty($cartContent['produtos'])) {
            echo '<p>Sua sacola está vazia</p>';
        } else {
            var_dump($cartContent);
            foreach ($cartContent['produtos'] as $produto) {
                echo '<div class="product-details">';
                
                // Verifique se a chave 'imagem' existe antes de usá-la
                if (isset($produto['imagem'])) {
                    echo '<img src="' . $produto['imagem'] . '" alt="' . $produto['nome'] . '">';
                }
                
                echo '<p class="product-name">' . $produto['nome'] . '</p>';
                echo '<p class="product-price">Preço: R$' . number_format($produto['preco'], 2, ',', '.') . '</p>';
                echo '<p class="product-quantity">Quantidade: ' . $produto['quantidade'] . '</p>';
                echo '</div>';
            }
        }
        echo '<p>Total: R$' . number_format($cartContent['total'], 2, ',', '.') . '</p>';
        ?>

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
</body>

</html>
