<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VENTANA MODAL CODEA</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');

        body{
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }
        .page{
            background: url(img/foto.jpg) center;
            height: 100vh; 
            display: flex;          
            justify-content: center;
            align-items: center;
        }
        .fondo_transparente{
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.226);
            position: absolute;
            height: 100vh;
            width: 100%;
            display: none;
        }
        .modal{
            background: linear-gradient(0deg,white 70%, crimson 30%);
            width: 600px;
            height: 300px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            position: absolute;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            border-radius: 30px;

        }
        .modal_cerrar{
            background: white;
            position: absolute;
            right: -20px;
            color: crimson;
            top: -20px;
            width: 40px;
            height: 40px;
            border-radius: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        .modal_titulo{
            color: white;
            font-size: 40px;
        }
        .modal_mensaje{            
           padding: 10px 30px;
        }
        .modal_botones{      
            width: 100%;    
           background: whitesmoke;
           border-top:whitesmoke 1px;
           padding-top: 20px;
           display: flex;
           justify-content: space-evenly;
        }
        
        .boton{
            background: white;
            padding: 8px 30px;
            color: crimson;
            text-decoration: none;
            border-radius: 25px;
            border:1px solid crimson
        }
        .boton:hover{
            background: crimson;
            color: white;
        }
            
    </style>
</head>
<body>
    <div class="page">
        <a href="#" class="boton" id="btnabrir">ABRIR VENTANA</a>
    </div>

    <div class="fondo_transparente">
        <div class="modal">
            <div class="modal_cerrar">
                <span>x</span>
            </div>
            <div class="modal_titulo">VENTANA MODAL</div>
            <div class="modal_mensaje">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Suscipit, nam? Minus nihil temporibus, minima reprehenderit, rem explicabo earum nemo debitis, maxime deserunt quidem. Quia odit quae voluptate nobis sit beatae!</p>
            </div>
            <div class="modal_botones">
                <a href="" class="boton">COMPARTIR</a>
                <a href="" class="boton">ACEPTAR</a>
            </div>
        </div>
    </div>   
</body>
</html>