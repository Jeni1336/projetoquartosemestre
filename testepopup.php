<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container{
            background-color: #333;
        }
    .popup{
        width: 400px;
        background: #fff;
        border-radius: 6px;
        position: absolute;
        top: 0%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.1);
        text-align: center;
        padding: 0 30px 30px;
        color: #333;
        visibility: hidden;
        transition: transform 0.4s, top 0.4s;
    }
    .open-popup{
        visibility: visible;
        top: 50%;
        transform: translate(-50%, -50%) scale(1);
    }
    .popup img {
        width: 100px;
        margin-top: -50px;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    .popup h2{
        font-size: 38px;
        font-weight: 500;
        margin: 30px 0 10px;
    }
    .popup button{
        width: 100%;
        margin-top: 50px;
        padding: 10px 0;
        background: #770624;
        color: #fff;
        border: 0;
        outline: none;
        font-size: 18px;
        border-radius: 4px;
        cursor: pointer;
        box-shadow: 0 5px 5px rgba(0, 0 ,0 , 0.2);
    }

    </style>
</head>
<body>
    <div class="container">
    <div class="popup" id="popup">

    <img src="https://i.imgur.com/7YFF2gB.png">
    <h2>Adicionado ao carrinho!</h2>
    <p>Produto adicionado ao carrinho com sucesso!</p>
    <button type="btn" onclick="closePopup()"> Ok</button>
    </div>

   <!-- <div class="popup">

    <img src="https://i.imgur.com/7YFF2gB.png">
    <h2>Adicionado aos salvos!</h2>
    <p>Produto adicionado aos salvos com sucesso!</p>
    <button type="btn"> Ok</button>
    </div>
    </div>-->

    <script>
        let popup = document.getElementById("popup");

        function openPopup(){
            popup.classList.add(".open-popup");
        }
        function closePopup(){
            popup.classList.remove(".open-popup");
        }
    </script>
</body>
</html>