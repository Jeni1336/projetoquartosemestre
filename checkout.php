<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="checkout.css">
  <title>Checkout</title>
</head>
<body>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Checkout</title>
    </head>
    <body>
      <div class="column left">
        <div class="content">
            <h1>Finalizar Compra</h1>
            </div>
            <div class="checkout-form">
              <h2>Endereço de entrega</h2>
              <strong><p>Logradouro: Avenida das Rosas</p></strong><br>
              <strong><p>Número: 180</p></strong><br>
              <strong><p>Complemento: Casa</p></strong><br>
              <strong><p>Bairro: Tulipas </p></strong><br>
              <strong><p>CEP: 18074-054</p></strong><br>
              <strong><p>Cidade:Sorocaba</p></strong><br>
            </div>
        </div>
    
      <div class="column right">
        <div class="content">
        <div class="checkout-form2">
          <h2>Forma de Pagamento</h2>
          <input type="radio"> <label for=""> Pix</label> <br>
          <input type="radio"> <label for=""> Boleto</label> <br>
          <input type="radio" onclick="openPopup()">Adicionar Cartão de Crédito</but>

  <div id="overlay">
    <div id="popup">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <h2>Adicionar Cartão de Crédito</h2>
      <form>
        <label for="cardNumber">Nome do Titular:</label>
        <input type="text" id="cardNumber" name="cardNumber" required> <br>

        <label for="cardNumber">CPF do Titular:</label>
        <input type="text" id="cardNumber" name="cardNumber" required> <br>

        <label for="cardNumber">Número do Cartão:</label>
        <input type="text" id="cardNumber" name="cardNumber" required> <br>

        <label for="expiryDate">Data de Validade:</label>
        <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/AA" required> <br>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required>

        <button type="submit">Adicionar Cartão</button>
      </form>
    </div>
  </div>
  <script>
    function openPopup() {
      document.getElementById('overlay').style.display = 'flex';
    }

    function closePopup() {
      document.getElementById('overlay').style.display = 'none';
    }
  </script>
        </div>      
        <div class="column1">
        <div class="content">
        <div class="checkout-form3">
          <h2>Itens</h2>
          <img src="/projetoquartosemestre/images/serum.jpg" alt="item">
          <p>1x Batom matte</p> <br>
         <strong> <p>Valor Total: R$ 30,00</p> </strong> 
        </div>
        </div>
        <button type="submit" class="btn-1">Finalizar Compra</button>
      </div>
    </div>
    </div>




</body>
</html>
