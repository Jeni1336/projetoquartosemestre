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
        global $pdo;
        $sql = $pdo-> prepare ("INSERT INTO cliente (nome, sobrenome, genero, data_nasc, email, senha) VALUES (:n, :sn, :g, :d, :e, :s)");
        $sql-> bindValue(":n", $nome, PDO::PARAM_STR); 
        $sql-> bindValue(":sn", $sobrenome, PDO::PARAM_STR); 
        $sql-> bindValue(":g", $genero, PDO::PARAM_STR); 
        $sql-> bindValue(":d", $data_nasc, PDO::PARAM_STR); 
        $sql-> bindValue(":e", $email, PDO::PARAM_STR); 
        $sql-> bindValue(":s", md5($senha), PDO::PARAM_STR); 

        
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

    public function editar($idUsuario, $nome, $sobrenome, $genero, $data_nasc, $email, $senha){
        global $pdo;
        try {
        $cmd = $pdo->prepare("UPDATE cliente SET nome = :n, sobrenome = :sn, genero = :g, data_nasc = :d, email = :e, senha = :s WHERE id=:id");
        $cmd-> bindValue(":n", $nome, PDO::PARAM_STR); 
        $cmd-> bindValue(":sn", $sobrenome, PDO::PARAM_STR); 
        $cmd-> bindValue(":g", $genero, PDO::PARAM_STR); 
        $cmd-> bindValue(":d", $data_nasc, PDO::PARAM_STR); 
        $cmd-> bindValue(":e", $email, PDO::PARAM_STR); 
        $cmd-> bindValue(":s", md5($senha), PDO::PARAM_STR); 
        $cmd->bindValue(":id", $idUsuario, PDO::PARAM_STR);
        $cmd->execute();
        return true; // Adicionado para indicar que a edição foi bem-sucedida
         } catch (PDOException $e) {
        $this->msgErro = $e->getMessage();
        return false;
    }
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
    public function cadastrarEndereco($idCliente, $endereco, $cidade, $bairro, $estado, $cep){
        global $pdo;
    
        // Verifica se já existe um endereço cadastrado para o cliente
        $sqlVerifica = $pdo->prepare("SELECT id FROM endereco WHERE id_cliente = :idCliente");
        $sqlVerifica->bindValue(":idCliente", $idCliente);
        $sqlVerifica->execute();
    
        if($sqlVerifica->rowCount() >= 3){
            return false; // Já está cadastrado
        } else {
            // Insere o novo endereço
            $sql = $pdo->prepare("INSERT INTO endereco (id_cliente, endereco, cidade, bairro, estado, cep) VALUES (:idCliente, :endereco, :cidade, :bairro, :estado, :cep)");
            $sql->bindValue(":idCliente", $idCliente, PDO::PARAM_INT);
            $sql->bindValue(":endereco", $endereco, PDO::PARAM_STR);
            $sql->bindValue(":cidade", $cidade, PDO::PARAM_STR);
            $sql->bindValue(":bairro", $bairro, PDO::PARAM_STR);
            $sql->bindValue(":estado", $estado, PDO::PARAM_STR);
            $sql->bindValue(":cep", $cep, PDO::PARAM_STR);
            
            $sql->execute();
            return true;
        }
    }
    
    function SelectEndereco($idCliente){
        global $pdo;
        
        // Preparar a consulta SQL
        $sql = $pdo->prepare("SELECT id, endereco, cidade, bairro, estado, cep FROM endereco WHERE id_cliente = :idCliente");
        $sql->bindValue(":idCliente", $idCliente);
        $sql->execute();
    
        // Verificar se há endereços cadastrados
        if ($sql->rowCount() > 0) {
            // Retornar todos os endereços em um array
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Se nenhum endereço for encontrado, retornar array vazio
            return array();
        }
    }

    function SelectMultiplosEnderecos($idEndereco){
        global $pdo;
        $sql = $pdo->prepare("SELECT id, endereco, cidade, bairro, estado, cep FROM endereco WHERE id = :idEndereco");
        $sql->bindValue(":idEndereco", $idEndereco);
        $sql->execute();
    
        // Verificar se há endereço cadastrado
        if ($sql->rowCount() > 0) {
            // Retornar o endereço como um array associativo
            return $sql->fetch(PDO::FETCH_ASSOC);
        } else {
            // Se nenhum endereço for encontrado, retornar array vazio
            return array();
        }
    }
    

   function DeleteEndereco($idEndereco){
    global $pdo;

    // Verificar se o endereço existe antes da exclusão
    $cmdVerifica = $pdo->prepare("SELECT id FROM endereco WHERE id = :idEndereco");
    $cmdVerifica->bindValue(":idEndereco", $idEndereco);
    $cmdVerifica->execute();

    if($cmdVerifica->rowCount() > 0){
        $cmd = $pdo->prepare("DELETE FROM endereco WHERE id = :idEndereco");
        $cmd->bindValue(":idEndereco", $idEndereco, PDO::PARAM_INT);
        $cmd->execute();
        $this->pdo = null; // Feche a conexão
        return true; // Exclusão bem-sucedida
    } else {
        return false; // Endereço não encontrado para exclusão
    }
}
   
    function EditarEndereco($idEndereco, $endereco, $cidade, $bairro, $estado, $cep){
        global $pdo;
        $sql = $pdo->prepare("UPDATE endereco SET endereco = :endereco, cidade = :cidade, bairro = :bairro, estado = :estado, cep = :cep WHERE id = :idEndereco");
        $sql->bindValue(":idEndereco", $idEndereco, PDO::PARAM_INT);
        $sql->bindValue(":endereco", $endereco, PDO::PARAM_STR);
        $sql->bindValue(":cidade", $cidade, PDO::PARAM_STR);
        $sql->bindValue(":bairro", $bairro, PDO::PARAM_STR);
        $sql->bindValue(":estado", $estado, PDO::PARAM_STR);
        $sql->bindValue(":cep", $cep, PDO::PARAM_STR);
        
        $sql->execute();
        return true;
    }
    //function get_endereco($cep){


        // formatar o cep removendo caracteres nao numericos
     //   $cep = preg_replace("/[^0-9]/", "", $cep);
     //   $url = "http://viacep.com.br/ws/$cep/xml/";
      
     //   $xml = simplexml_load_file($url);
     //   return $xml;
     // }
      
     function AdicionarCartao($idCliente, $nome, $numero_cartao, $cvv, $data_vencimento, $cpf){
        global $pdo;
    
        // Verifica se já existe um cartao cadastrado para o cliente
        $sqlVerifica = $pdo->prepare("SELECT id FROM cartao WHERE id_cliente = :idCliente");
        $sqlVerifica->bindValue(":idCliente", $idCliente);
        $sqlVerifica->execute();
    
        if($sqlVerifica->rowCount() > 0){
            return false; // Já está cadastrado
        } else {
            // Insere o novo endereço
            $sql = $pdo->prepare("INSERT INTO cartao (id_cliente, nome, numero_cartao, cvv, data_vencimento, cpf) VALUES (:idCliente, :n, :nc, :cvv, :d, :cpf)");
            $sql->bindValue(":idCliente", $idCliente, PDO::PARAM_INT);
            $sql->bindValue(":n", $nome, PDO::PARAM_STR);
            $sql->bindValue(":nc", $numero_cartao, PDO::PARAM_STR);
            $sql->bindValue(":cvv", md5($cvv), PDO::PARAM_STR);
            $sql->bindValue(":d", $data_vencimento, PDO::PARAM_STR);
            $sql->bindValue(":cpf", $cpf, PDO::PARAM_STR);
            
            $sql->execute();
            return true;
        }

     }
     function SelectCartao($idCliente){
        global $pdo;
        // Preparar a consulta SQL
        $sql = $pdo->prepare("SELECT nome, numero_cartao, cvv, data_vencimento, cpf FROM cartao WHERE id_cliente = :idCliente");
        $sql->bindValue(":idCliente", $idCliente);
        $sql->execute();
    
        // Verificar se há cartão cadastrado
        if ($sql->rowCount() > 0) {
            return $sql->fetch(PDO::FETCH_ASSOC);
        } else {
            // Se nenhum cartão for encontrado, retornar array vazio
            return array();
        }
    }
    
    function RemoverCartao($idCliente){
        global $pdo;
        //VERIFICANDO SE EXISTE ANTES DA EXCLUSAO
        $cmdVerifica = $pdo->prepare("SELECT id FROM cartao WHERE id_cliente = :idCliente");
        $cmdVerifica->bindValue(":idCliente", $idCliente);
        $cmdVerifica->execute();
            
        if($cmdVerifica->rowCount() > 0){
            $cmd = $pdo->prepare("DELETE FROM cartao WHERE id_cliente = :idCliente");
            $cmd->bindValue(":idCliente", $idCliente, PDO::PARAM_INT);
            $cmd->execute();
            $this->pdo = null; // Feche a conexão
            return true; //exclusão deboa
        }else{
            return false; //sem endereço p excluir
        }

    }
    

}
?>
