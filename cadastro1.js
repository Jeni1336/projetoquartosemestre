
function confereSenha()
{
    const senha = document.querySelector('input[name=senha]');
    const confirma = document.querySelector('input[name=confirmar_senha]');

    if(confirma.value === senha.value){
        confirma.setCustomValidity('');
    }else{
       // confirma.setCustomValidity('As senhas não conferem');
       alert ('Senhas incorretas!');
    }
}

function cadastroRealizado(){
    alert ("Cadastro realizado com sucesso! Faça o login para continuar.");
}

function msgErro(){

    alert ("Não foi possível fazer o login, email já cadastrado.");
}



