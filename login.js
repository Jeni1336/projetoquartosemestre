function logar (){
    var login = document.getElementById('login').value;
    var senha = document.getElementById('senha').value;

    if (login == "admin" && senha == "admin"){
        location.href = "telainicial.html";
    }else{
        alert ('email ou senha incorretos')
    }
}