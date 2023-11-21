<?php
session_start();

if (isset($_POST['remove_from_saved'])) {
    $id_produto_to_remove = $_POST['remove_from_saved'];

    // Certifique-se de que a sessão 'salvos' existe
    if (isset($_SESSION['salvos']) && is_array($_SESSION['salvos'])) {
        // Procure o item pelo ID do produto e remova-o
        foreach ($_SESSION['salvos'] as $key => $item) {
            if ($item['id_produto'] == $id_produto_to_remove) {
                unset($_SESSION['salvos'][$key]);
                // Reorganize os índices do array para evitar índices ausentes
                $_SESSION['salvos'] = array_values($_SESSION['salvos']);
                break; // Termina o loop assim que o item é removido
            }
        }
    }
}
header("location:salvos.php")
?>

<script>
    // Função para remover um item salvo
    function removerDosSalvos(id) {
        fetch('remover_dos_salvos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'remove_from_saved=' + id,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redireciona apenas se a remoção for bem-sucedida
                window.location.href = 'salvos.php';
            } else {
                console.error('Erro ao remover dos Salvos:', data.message);
            }
        })
        .catch(error => console.error('Erro ao realizar a solicitação:', error));
    }
</script>

