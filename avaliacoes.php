<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="avaliacoes.css">
    <title>Feedback de Produtos</title>
    
</head>
<body>

    <div class="feedback-form">
        <h2>Avaliar Produto</h2>
        <form id="productFeedbackForm">
            <div class="form-group">
                <label for="productName"> Produto:</label>
                <select >
                    <option value="">Batom Matte</option>
                    <option value="">Kit de Maquiagem</option>
                    <option value="">Máscara de Cílios</option>
                    <option value="">Sérum</option>
                </select>
            </div>

            <div class="form-group">
                <label for="rating">Nota:</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required>
            </div>

            <div class="form-group">
                <label for="comments">Comentários:</label>
                <textarea id="comments" name="comments" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <button class="btn-avaliar" type="submit"  onclick="openAlert()">Enviar Feedback </button>
                <button class="btn" onclick="redirecionarParaOutraPagina()">Voltar</button>
            </div>
            <div id="overlay">
                <div id="popup">
                  <span class="close-btn" onclick="openAlert()">&times;</span>
        </form>
    </div>
    <script>
        function openAlert() {
          document.getElementById('overlay');
          alert("Sua avaliação foi enviada")
        }

    function redirecionarParaOutraPagina() {
        window.location.href = '/www2/projetoquartosemestre/telainicial.php.';
    }
      </script>
       

</html>
