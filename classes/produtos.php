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