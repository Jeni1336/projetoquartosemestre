
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



