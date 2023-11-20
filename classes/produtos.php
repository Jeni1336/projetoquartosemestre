<?php

class Produto {
    private int $id;
    private string $nome;
    private string $descricao;
    private int $preco;
    private int $quantidade;
    
    public function __construct(
        int $id = 0,
        string $nome = '',
        string $descricao = '',
        int $preco = 0,
        int $quantidade = 0
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
    }
    public function cadastrarProduto($nome, $descricao, $preco, $quantidade, $imagem, $url_absoluta)
    {
        global $pdo;
    
        // Check if the product with the same name already exists
        $sql = $pdo->prepare("SELECT id FROM produtos WHERE nome = :produto_nome");
        $sql->bindValue(":produto_nome", $nome, PDO::PARAM_STR);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            return false; // Product already exists
        } else {
            // Insert the new product
            $sql = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco, quantidade, imagem, url_absoluta) VALUES (:produto_nome, :produto_descricao, :produto_preco, :produto_quantidade, :produto_imagem, :produto_url)");
    
            // Assuming 'imagem' in the database is a VARCHAR field to store the URL
            $sql->bindValue(":produto_nome", $nome, PDO::PARAM_STR);
            $sql->bindValue(":produto_descricao", $descricao, PDO::PARAM_STR);
            $sql->bindValue(":produto_preco", $preco, PDO::PARAM_STR);
            $sql->bindValue(":produto_quantidade", $quantidade, PDO::PARAM_STR);
            $sql->bindValue(":produto_imagem", $imagem, PDO::PARAM_STR); // Assuming 'imagem' is the column to store the URL
            $sql->bindValue(":produto_url", $url_absoluta, PDO::PARAM_STR);
            
            if ($sql->execute()) {
                return true; // Product successfully added
            } else {
                return false; // Error in the database insertion
            }
        }
    }
public function obterDadosProduto() {
    global $pdo;
 $sql = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $sql->bindValue(":id", $idProduto);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return $sql->fetch(PDO::FETCH_ASSOC);
        } else {
            return false; // Usuário não encontrado
        }
    } 
    public function CreateUniqueId(){
        $charecters =
        '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ';
        $charecters_lenght = strlen($charecters);
        $random = '';
        for($i = 0;$i<20; $i++){
            $random .= $charecters[mt_rand(0, $charecters_lenght - 1)];

        }
        return $random;

    }


    // Getter methods
    public function getId(): int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function getPreco(): int {
        return $this->preco;
    }

    public function getQuantidade(): int {
        return $this->quantidade;
    }

    // Setter methods
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setDescricao(string $descricao): void {
        $this->descricao = $descricao;
    }

    public function setPreco(int $preco): void {
        $this->preco = $preco;
    }

    public function setQuantidade(int $quantidade): void {
        $this->quantidade = $quantidade;
    }
}

?>