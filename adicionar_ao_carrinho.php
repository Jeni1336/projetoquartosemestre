<?php
require_once '../projetoquartosemestre/classes/usuarios.php';
require_once '../projetoquartosemestre/classes/cart.php';

$objUsuario = new Usuario();
$objUsuario->conectar("cadastro_cliente", "localhost", "root", "admin");

session_start();

// Verifique se o usuário está logado
$usuario = $objUsuario->obterDadosUsuarioLogado();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(["status" => "error", "message" => "Você precisa estar logado para adicionar produtos ao carrinho."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados da solicitação
    $produtoId = $_POST["produtoId"];
    $quantidade = $_POST["quantidade"];

    // Adicione a lógica para adicionar o produto ao carrinho (usando a classe Cart)
    $pdo = new PDO('mysql:host=localhost;dbname=cadastro_cliente', 'root', 'admin'); // Certifique-se de ajustar as credenciais
    $cart = new Cart($pdo);
    $cart->addToCart($produtoId, $quantidade);

    // Retorne uma resposta (pode ser um JSON)
    echo json_encode(["status" => "success", "message" => "Produto adicionado ao carrinho com sucesso!", "cart" => $cart->getCart()]);
} else {
    // Se a solicitação não for POST, retorne um erro
    echo json_encode(["status" => "error", "message" => "Método não permitido"]);
}
?>
