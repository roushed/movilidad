<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
    <?php 
        session_start();
        if (isset($_SESSION["autentificado"])){
            header("Location: infractores.php");
        }
    ?>
</head>
<body>


<div class="divppl">
    <div class="container">

        <div class="titulo">
            <h1>Gestión de Movilidad</h1>
        </div>
        <div class="formula">
            <form method="post" action="autentica.php">
                <h2>Login:</h2>
                <p><label class='login'><b>Usuario:</b></label><input type="text" name="usuario"></p>
                <p><label class='login'><b>Password:</b></label><input type="password" name="contrasena"></p>
                <p><input type="submit" value="Enviar" name="envio"></p>
            </form>
            <div id="msgerror" class="msgerror">

            <?php
                if(isset($_GET['errorusuario'])){
                    if($_GET['errorusuario'] == 1){

                        echo "Nombre de usuario o contraseña incorrecto";

                    }if($_GET['errorusuario'] == 2){
                        
                        echo "Los campos se encuentran vacios";
                    }
                }



            ?>

            </div>
        </div>
        <p><a href='./movilidad.php'>Atras</a></p>
    </div>
</div>
</body>
</html>