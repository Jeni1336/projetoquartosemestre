<?php

Class Usuario{

    public $pdo;
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
        $sql = $pdo -> prepare("SELECT id FROM cliente WHERE email = :e");
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
        global $pdo;
        $sql = $pdo-> prepare ("INSERT INTO cliente (nome, sobrenome, genero, data_nasc, email, senha) VALUES (:n, :sn, :g, :d, :e, :s)");
        $sql-> bindValue(":n", $nome, PDO::PARAM_STR); 
        $sql-> bindValue(":sn", $sobrenome, PDO::PARAM_STR); 
        $sql-> bindValue(":g", $genero, PDO::PARAM_STR); 
        $sql-> bindValue(":d", $data_nasc, PDO::PARAM_STR); 
        $sql-> bindValue(":e", $email, PDO::PARAM_STR); 
        $sql-> bindValue(":s", md5($senha), PDO::PARAM_STR); 

        //$sql = $pdo-> prepare ("INSERT INTO cliente ('".$nome."' , '".$sobrenome."','".$genero."' ,'".$data_nasc."' , '".$email."' , '".$senha."' );"); 
        //mysqli_query($strcon, $sql) or die ('Erro ao tentar cadastrar registro');
        $sql->execute();
        return true;
        
    } }

    public function logar($email, $senha){
        global $pdo;
        $sql = $pdo -> prepare("SELECT id FROM cliente WHERE 
        email = :e AND senha = :s");
        $sql -> bindValue(":e", $email);
        $sql -> bindValue(":s", md5($senha));
        $sql -> execute();
        if($sql->rowCount() > 0)
        {
            //entrar no sistema (sessao)
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id'] = $dado['id'];
            return true;//logado com sucesso
    }else{
        return false; //nao foi possivel logar
    }

    }
    public function deletar($idUsuario) {
        global $pdo;
        // Verifique se $this->pdo está definido antes de chamar prepare
            $cmd = $pdo->prepare("DELETE FROM cliente WHERE id=:id");
            $cmd->bindValue(":id", $idUsuario);
            $cmd->execute();
            $this->pdo = null; // Feche a conexão

}

    public function editar($nome, $sobrenome, $genero, $data_nasc, $email, $senha){
        global $pdo;


    }
    public function obterDadosUsuarioLogado() {
        global $pdo;

        // Verificar se a sessão está ativa
        if (isset($_SESSION['id'])) {
            $idUsuario = $_SESSION['id'];

            $sql = $pdo->prepare("SELECT * FROM cliente WHERE id = :id");
            $sql->bindValue(":id", $idUsuario);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            } else {
                return false; // Usuário não encontrado
            }
        } else {
            return false; // Sessão não está ativa
        }
    }

}

?>