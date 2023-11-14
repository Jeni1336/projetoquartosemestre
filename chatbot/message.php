<?php
// connecting to database
$conn = mysqli_connect("localhost", "root", "admin", "cadastro_cliente") or die("Database Error");

// getting user message through ajax
$getMesg = isset($_POST['text']) ? mysqli_real_escape_string($conn, $_POST['text']) : "";

//checking user query to database query
$check_data = "SELECT replies FROM chatbot WHERE queries LIKE '%$getMesg%'";
$run_query = mysqli_query($conn, $check_data) or die("Error");

// if user query matched to database query we'll show the reply otherwise it go to else statement
if(mysqli_num_rows($run_query) > 0){
    $fetch_data = mysqli_fetch_assoc($run_query);
    $replay = $fetch_data['replies'];
    echo $replay;
} else {
    error_log("Erro: " . mysqli_error($conn));  // Adicione esta linha para registrar o erro
    echo "Desculpe, não consegui te entender!";
}

?>