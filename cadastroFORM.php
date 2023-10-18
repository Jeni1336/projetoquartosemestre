<?php
$nome = $_POST ['nome'];
$sobrenome = $_POST ['sobrenome'];
$genero = $_POST ['genero'];
$data_nasc = $_POST ['data_nasc'];
$email = $_POST ['email'];
$senha = $_POST ['senha'];
$strcon = mysqli_connect ("localhost", "root", "admin", "cadastro_cliente") or die("Erro ao conectar com o banco");
$sql = "INSERT INTO cliente VALUES('".$nome."' , '".$sobrenome."','".$genero."' ,'".$data_nasc."' , '".$email."' , '".$senha."' );"; 
mysqli_query($strcon, $sql) or die ('Erro ao tentar cadastrar registro');
echo "Funcionario cadastrado com sucesso";
header("location: telainicial.html");

?>