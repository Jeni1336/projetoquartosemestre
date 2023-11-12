
<?php
class Product {
    private int $id;
    private string $nome;
    private string $descricao;
    private int $preco;
    private int $quantidade;

    public function __construct(int $id, string $nome, string $descricao, int $preco, int $quantidade) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
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
}

?>