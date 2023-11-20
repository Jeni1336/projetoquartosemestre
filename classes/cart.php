<?php
require_once '../projetoquartosemestre/classes/produtos.php';
require_once '../projetoquartosemestre/classes/usuarios.php';
class Cart {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function addToCart(int $produtoId, int $quantidade) {
        $produto = $this->getProdutoById($produtoId);

        if ($produto) {
            $produtoToAdd = new Produto(
                $produto['id'],
                $produto['nome'],
                $produto['descricao'],
                $produto['preco'],
                $quantidade
            );
            
        }
    }
    


     private function getProdutoFromDatabase(int $produtoId) {
        $query = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $query->bindParam(':id', $produtoId);
        $query->execute();

        $product = $query->fetch(PDO::FETCH_ASSOC);
        error_log("Produto recuperado do banco de dados: " . print_r($product, true));

        return $product;
    }
    
    

    private function getProdutoById(int $produtoId) {
        $query = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $query->bindParam(':id', $produtoId);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    private function addProdutoToCart(Produto $produto) {
        $cart = $this->getCart();
    
        // Inicialize $cart['produtos'] se ainda não existir
        if (!isset($cart['produtos'])) {
            $cart['produtos'] = array();
        }
    
        $cart['produtos'][] = array(
            'id' => $produto->getId(),
            'nome' => $produto->getNome(),
            'descricao' => $produto->getDescricao(),
            'preco' => $produto->getPreco(),
            'quantidade' => $produto->getQuantidade()
        );
    
        $this->updateTotal($cart, $produto);
        $this->saveCartToSession($cart);
    }
    
    private function saveCartToSession(array $cart) {
        // Inicie a sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        // Armazene os dados do carrinho na sessão
        $_SESSION['cart'] = $cart;
    }

    
    
    private function updateTotal(array &$cart, Produto $produto) {
        // Inicialize $cart['total'] se ainda não existir
        if (!isset($cart['total'])) {
            $cart['total'] = 0;
        }
    
        $cart['total'] += $produto->getPreco() * $produto->getQuantidade();
    }
    

    public function getCart() {
        $cart = $_SESSION['cart'] ?? ['produtos' => [], 'total' => 0];
    
        // Loop através dos produtos e recuperar detalhes do banco de dados
        foreach ($cart['produtos'] as &$produtoInCart) {
            $produtoDetails = $this->getProdutoFromDatabase($produtoInCart['id']);
            if ($produtoDetails) {
                $produtoInCart['nome'] = $produtoDetails['nome'];
                $produtoInCart['descricao'] = $produtoDetails['descricao'];
                $produtoInCart['preco'] = $produtoDetails['preco'];
            }
        }
    
        return $cart;
    }
    

    function adicionarAoCarrinho( $id_cliente, $id_produto, $quantidade) {
       global $pdo;
        try {
            // Verificar se o produto já está no carrinho
            $verify_cart = $pdo->prepare("SELECT * FROM `carrinho` WHERE id_cliente = :id_Cliente AND id_produto = :id_produto");
            $verify_cart->bindValue(":id_cliente", $id_cliente, PDO::PARAM_INT); // Certifique-se de vincular como um parâmetro inteiro
            $verify_cart->bindValue(":id_produto", $id_produto, PDO::PARAM_INT); // Certifique-se de vincular como um parâmetro inteiro
            $verify_cart->execute([$id_cliente, $id_produto]);
    
            // Verificar se o carrinho já está cheio
            $max_cart_items = $pdo->prepare("SELECT COUNT(*) as count FROM `carrinho` WHERE id_cliente = :id_cliente");
            $max_cart_items->bindValue(":id_cliente", $id_cliente, PDO::PARAM_INT); // Certifique-se de vincular como um parâmetro inteiro
            $max_cart_items->execute([$id_cliente]);
            $cart_count = $max_cart_items->fetchColumn();
    
            if ($verify_cart->rowCount() > 0) {
                return 'Já adicionado ao carrinho!';
            } elseif ($cart_count == 10) {
                return 'Carrinho está cheio!';
            } else {
                // Obter o preço do produto
                $select_price = $pdo->prepare("SELECT preco FROM `produtos` WHERE id = :id_produto LIMIT 1");
                $select_price -> bindValue(":id", $id_produto, PDO::PARAM_INT);
                $select_price->execute([$id_produto]);
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