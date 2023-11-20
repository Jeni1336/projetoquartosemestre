<?php
require_once '../projetoquartosemestre/classes/produtos.php';
require_once '../projetoquartosemestre/classes/usuarios.php';
class Cart {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    
    private function saveCartToSession(array $cart) {
        // Inicie a sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        // Armazene os dados do carrinho na sessão
        $_SESSION['cart'] = $cart;
    }



    function adicionarAoCarrinho($pdo, $id_cliente, $id_produto, $quantidade) {
        try {
           // Verificar se o produto já está no carrinho
           $verify_cart = $pdo->prepare("SELECT * FROM `carrinho` WHERE id_cliente = :id_cliente AND id_produto = :id_produto");
           $verify_cart->bindValue(":id_cliente", $id_cliente, PDO::PARAM_INT);
           $verify_cart->bindValue(":id_produto", $id_produto, PDO::PARAM_INT);
           $verify_cart->execute();
     
           // Verificar se o carrinho já está cheio
           $max_cart_items = $pdo->prepare("SELECT COUNT(*) as count FROM `carrinho` WHERE id_cliente = :id_cliente");
           $max_cart_items->bindValue(":id_cliente", $id_cliente, PDO::PARAM_INT);
           $max_cart_items->execute();
           $cart_count = $max_cart_items->fetchColumn();

            if ($verify_cart->rowCount() > 0) {
                return 'Já adicionado ao carrinho!';
            } elseif ($cart_count == 10) {
                return 'Carrinho está cheio!';
            } else {
                // Obter o preço do produto
                $select_price = $pdo->prepare("SELECT preco FROM `produtos` WHERE id = :id_produto LIMIT 1");
                $select_price->bindValue(":id_produto", $id_produto, PDO::PARAM_INT);
                $select_price->execute();
                $preco = $select_price->fetchColumn();

            // Inserir no carrinho
            $insert_cart = $pdo->prepare("INSERT INTO `carrinho` (id_cliente, id_produto, preco, quantidade) VALUES (?, ?, ?, ?)");
            $insert_cart->execute([$id_cliente, $id_produto, $preco, $quantidade]);

            return 'Adicionado ao carrinho!';
        }
    } catch (PDOException $e) {
        // Lidar com exceções do PDO aqui
                 return 'Erro: ' . $e->getMessage();
             }
 }
    
}
    
    
    


?>