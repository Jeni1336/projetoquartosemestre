<?php 

class Cart{
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = ['products' => [], 'total' => 0];
        }
    }

    public function addToCart(int $productId, int $quantidade) {
        $product = $this->getProductById($productId);

        if ($product) {
            $productToAdd = new Product(
                $product['id'],
                $product['nome'],
                $product['descricao'],
                $product['preco'],
                $quantidade
            );

            // Add the product to the cart
            $this->addProductToCart($productToAdd);
        }
    }

    private function getProductById(int $productId) {
        $query = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $query->bindParam(':id', $productId);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    private function addProductToCart(Product $product) {
        $this->getCart()['products'][] = $product;
        $this->updateTotal($product);
    }

    private function updateTotal(Product $product) {
        $this->getCart()['total'] += $product->getPreco() * $product->getQuantidade();
    }

    public function add(Product $product){
    $inCart = false;
    $this->setTotal($product);
    if(count($this->getCart()['products']) > 0)
    {foreach($this->getCart()['products'] as $productInCart){
    if($productInCart->getId() === $product->getId()){
        $quantidade = $productInCart->getQuantidade() + $product->getQuantidade();
        $productInCart->setQuantidade($quantidade);
        $inCart = true;
        break;
    }
    
    }
    }if(!$inCart){
    $this->setProductsInCart($product);
    }
    }   
    private function setProductsInCart($product){
    $this->getCart()['products'][] = $product; 
    }
    private function setTotal(Product $product){
    $this->getCart()['total'] += $product->getPreco() * $product->getQuantidade();

    }
    public function removeProduct(int $productId) {
        $cartProducts = &$this->getCart()['products'];

        foreach ($cartProducts as $key => $productInCart) {
            if ($productInCart->getId() === $productId) {
                // Subtract the product's price from the total
                $this->getCart()['total'] -= $productInCart->getPreco() * $productInCart->getQuantidade();

                // Remove the product from the cart
                unset($cartProducts[$key]);
                break;
            }
        }
    }

public function getCart(){
    return $_SESSION['cart'] ?? [];


}
}
?>