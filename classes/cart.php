<?php
require_once '../projetoquartosemestre/classes/produtos.php';
class Cart {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function addToCart(int $produtoId, int $quantidade) {
        $produto = $this->getProdutoById($produtoId);
    
        if ($produto) {
            // var_dump("Produto recuperado do banco de dados:", $produto);
    
            $produtoToAdd = new Produto(
                $produto['id'],
                $produto['nome'],
                $produto['descricao'],
                $produto['preco'],
                $quantidade
            );
    
            // var_dump("Produto a ser adicionado à sacola:", $produtoToAdd);
    
            // Adicione ou atualize o produto no banco de dados
            $this->addOrUpdateProdutoToDatabase($produtoToAdd);
        }
    }
    

    private function addOrUpdateProdutoToDatabase(Produto $produto) {
        // Verifique se o produto já existe no banco de dados
        $existingProduto = $this->getProdutoFromDatabase($produto->getId());
    
        if ($existingProduto) {
            // Atualize a quantidade do produto se ele já estiver no banco de dados
            $quantidade = $existingProduto['quantidade'] + $produto->getQuantidade();
            $this->updateProdutoInDatabase($produto->getId(), $quantidade);
        } else {
            // Insira o novo produto no banco de dados
            $this->insertProdutoIntoDatabase($produto);
        }
    }
    private function getProdutoFromDatabase(int $produtoId) {
    $dsn = 'mysql:host=localhost;dbname=cadastro_cliente';
    $username = 'root';
    $password = 'admin';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erro na conexão com o banco de dados: ' . $e->getMessage());
    }

    // Consulta SQL para obter o produto com base no ID
    $query = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $query->bindParam(':id', $produtoId, PDO::PARAM_INT);
    $query->execute();

    // Retorna os resultados como um array associativo
    return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    private function updateProdutoInDatabase(int $produtoId, int $quantidade) {
        // Conectar ao banco de dados usando o PDO
        $dsn = 'mysql:host=localhost;dbname=cadastro_cliente';
        $username = 'root';
        $password = 'admin';
    
        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro na conexão com o banco de dados: ' . $e->getMessage());
        }
    
        // Consulta SQL para atualizar a quantidade do produto no banco de dados
        $query = $pdo->prepare("UPDATE produtos SET quantidade = :quantidade WHERE id = :id");
        $query->bindParam(':id', $produtoId, PDO::PARAM_INT);
        $query->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $query->execute();
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
    

    private function getProdutoById(int $produtoId) {
        $query = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $query->bindParam(':id', $produtoId);
        $query->execute();
    
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    private function addProdutoToCart(Produto $produto) {
        $cart = $this->getCart();
        $cart['produto'][] = $produto;
    
        $this->updateTotal($cart, $produto);
        $this->saveCartToCookie($cart);
    
    }
    
    private function updateTotal(array &$cart, Produto $produto) {
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
            unset($this->getCart()['produto'][$produtoId]);
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
        $cartData = $_COOKIE['cart'] ?? null;
        $cart = json_decode($cartData, true) ?? ['produto' => [], 'total' => 0];
    
        // Loop através dos produtos e recuperar detalhes do banco de dados
        foreach ($cart['produto'] as &$produtoInCart) {
            $produtoDetails = $this->getProdutoFromDatabase($produtoInCart->getId());
            if ($produtoDetails) {
                $produtoInCart->setNome($produtoDetails['nome']);
                $produtoInCart->setDescricao($produtoDetails['descricao']);
                $produtoInCart->setPreco($produtoDetails['preco']);
            }
        }
    
        return $cart;
    }
    

    private function saveCartToCookie(array $cart) {
        $cartData = json_encode($cart);
        setcookie('cart', $cartData, time() + (86400 * 30), "/"); // cookie válido por 30 dias
    }
}
?>