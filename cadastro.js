function cadastro (){
    var botao = document.getElementById ('btn');
        location.href = "login2.html";

        alert ('Realize o login para continuar')
}

function confereSenha()
{
    const senha = document.querySelector('input[name=senha]');
    const confirma = document.querySelector('input[name=confirmar_senha]');

    if(confirma.value === senha.value){
        confirma.setCustomValidity('');
    }else{
        confirma.setCustomValidity('As senhas não conferem');
    }
}

