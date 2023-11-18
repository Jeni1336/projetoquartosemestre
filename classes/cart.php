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

            $this->addOrUpdateProdutoToDatabase($produtoToAdd);
        }
    }
    

    private function addOrUpdateProdutoToDatabase(Produto $produto) {
        $existingProduto = $this->getProdutoFromDatabase($produto->getId());

        if ($existingProduto) {
            $quantidade = $existingProduto['quantidade'] + $produto->getQuantidade();
            $this->updateProdutoInDatabase($produto->getId(), $quantidade);
        } else {
            $this->insertProdutoIntoDatabase($produto);
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
    
    private function updateProdutoInDatabase(int $produtoId, int $quantidade) {
        $query = $this->pdo->prepare("UPDATE produtos SET quantidade = :quantidade WHERE id = :id");
        $query->bindParam(':id', $produtoId, PDO::PARAM_INT);
        $query->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $query->execute();
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
    private function insertProdutoIntoDatabase(Produto $produto) {
        $dsn = 'mysql:host=localhost;dbname=cadastro_cliente';
        $username = 'root';
        $password = 'admin';
    
        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro na conexão com o banco de dados: ' . $e->getMessage());
        }
    
        // Obtenha os valores dos métodos e armazene em variáveis
        $id = $produto->getId();
        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $preco = $produto->getPreco();
        $quantidade = $produto->getQuantidade();
    
        // Consulta SQL para inserir o novo produto no banco de dados
        $query = $pdo->prepare("INSERT INTO produtos (id, nome, descricao, preco, quantidade) VALUES (:id, :nome, :descricao, :preco, :quantidade)");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':nome', $nome, PDO::PARAM_STR);
        $query->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $query->bindParam(':preco', $preco, PDO::PARAM_INT);
        $query->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $query->execute();
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
    
            // Remove o produto do banco de dados
            $this->removeProdutoFromDatabase($produtoId);
    
            // Remove o produto do carrinho
            unset($this->getCart()['produtos'][$produtoId]);
        }
    }
    
    private function removeProdutoFromDatabase(int $produtoId) {
        try {
            // Consulta SQL para excluir o produto com base no ID
            $query = $this->pdo->prepare("DELETE FROM produtos WHERE id = :id");
            $query->bindParam(':id', $produtoId, PDO::PARAM_INT);
            $query->execute();
        } catch (PDOException $e) {
            die('Erro ao remover o produto do banco de dados: ' . $e->getMessage());
        }
    }

    public function getCart() {
        session_start(); // Inicie a sessão se ainda não estiver iniciada

        $cartData = $_SESSION['cart'] ?? null;
        $cart = json_decode($cartData, true) ?? ['produtos' => [], 'total' => 0];

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

    

}
?>