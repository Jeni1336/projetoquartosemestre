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
    public function removeProduto(int $produtoId) {
        $produto = $this->getProdutoById($produtoId);
    
        if ($produto) {
            // Subtrai o preço do produto do total
            $this->getCart()['total'] -= $produto['preco'] * $produto['quantidade'];
    
    
            // Remove o produto do carrinho
            unset($this->getCart()['produtos'][$produtoId]);
        }
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
    

    public function ContarItensCarrinho($idCliente) {
        $query = $this->pdo->prepare("SELECT COUNT(*) as total FROM carrinho WHERE id_cliente = :idCliente");
        $query->bindParam(":idCliente", $idCliente);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $totalItensCarrinho = $result['total'];
        return $totalItensCarrinho;
    }
    
    

}
?>