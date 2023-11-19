<?php
require_once '../projetoquartosemestre/classes/usuarios.php';
require_once '../projetoquartosemestre/classes/cart.php';

// Inicie a sessão
if (empty($_SESSION)) {
    session_start();}

// Verifique se o usuário está logado
$objUsuario = new Usuario();
$objUsuario->conectar("cadastro_cliente", "localhost", "root", "admin");

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Usuário não está logado"]);
    exit;
}

// Verifique se a solicitação é do tipo POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Método não permitido"]);
    exit;
}

// Obtenha os dados da solicitação
$produtoId = $_POST["produtoId"];
$quantidade = $_POST["quantidade"];

// Conecte-se ao banco de dados
try {
    $pdo = new PDO('mysql:host=localhost;dbname=cadastro_cliente', 'root', 'admin');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Erro na conexão com o banco de dados: " . $e->getMessage()]);
    exit;
}

// Crie uma instância da classe Cart
$cart = new Cart($pdo);

// Adicione o produto ao carrinho
$cart->addToCart($produtoId, $quantidade);

// Retorne uma resposta JSON
header('Content-Type: application/json');
echo json_encode(["status" => "success", "message" => "Produto adicionado ao carrinho com sucesso!", "cart" => $cart->getCart()]);
?>
