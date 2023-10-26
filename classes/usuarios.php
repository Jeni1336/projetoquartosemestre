<?php

Class Usuario{

    private $pdo;
    public $msgErro = "";

    public function conectar($nome, $host, $usuario, $senha){
        global $pdo;
        try{
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);

        } catch(PDOException $e) {
       $msgErro = $e->getMessage();
    }
}

    public function cadastrar($nome, $sobrenome, $genero, $data_nasc, $email, $senha){
        global $pdo;
        //verificar se já existe o email cadastrado
        $sql = $pdo -> prepare("SELECT id_cliente FROM cliente WHERE email = :e");
        $sql -> bindValue(":e", $email);
        $sql -> execute();
        if($sql -> rowCount() > 0){
            return false; //ja esta cadastrado
    }
    else{
        //$nome = $_POST ['nome'];
        //$sobrenome = $_POST ['sobrenome'];
        //$genero = $_POST ['genero'];
        //$data_nasc = $_POST ['data_nasc'];
        //$email = $_POST ['email'];
        //$senha = $_POST ['senha'];
        //$strcon = mysqli_connect ("localhost", "root", "admin", "cadastro_cliente") or die("Erro ao conectar com o banco");
        $sql = $pdo-> prepare ("INSERT INTO cliente (nome, sobrenome, genero, data_nasc, email, senha) VALUES (:n, :sn, :g, d, :e, :s)");
        $sql-> bindValue(":n", $nome); 
        $sql-> bindValue(":sn", $sobrenome); 
        $sql-> bindValue(":g", $genero); 
        $sql-> bindValue(":d", $data_nasc); 
        $sql-> bindValue(":e", $email); 
        $sql-> bindValue(":s", $senha); 

        //$sql = $pdo-> prepare ("INSERT INTO cliente ('".$nome."' , '".$sobrenome."','".$genero."' ,'".$data_nasc."' , '".$email."' , '".$senha."' );"); 
        //mysqli_query($strcon, $sql) or die ('Erro ao tentar cadastrar registro');
        $sql->execute();
        return true;
        //header("location: telainicial.html");
    } }

    public function logar($email, $senha){
        global $pdo;
        $sql = $pdo -> prepare("SELECT id_cliente FROM cliente WHERE 
        email = :e AND senha = :s");
        $sql -> bindValue(":e", $email);
        $sql -> bindValue(":s", $senha);
        $sql -> execute();
        if($sql->rowCount() > 0)
        {
            //entrar no sistema (sessao)
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id_cliente'] = $dado['id_cliente'];
            return true;//logado com sucesso
    }else{
        return false; //nao foi possivel logar
    }

}
    }

?>