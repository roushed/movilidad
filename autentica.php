<?php
    session_start();

    if(!isset($_SESSION['autentificado'])){

        if(!empty($_POST['usuario']) && !empty($_POST['contrasena'])){

            if($_POST['usuario'] == "prueba" && $_POST['contrasena'] == "1234" ){
                $_SESSION['usuario']=$_POST['usuario'];
                $_SESSION['autentificado'] = true;
                header("Location: infractores.php");


            }else{

                header("Location: login.php?errorusuario=1");
                
            }


        }else{

            header("Location: login.php?errorusuario=2");
        }


    }else{

        header("Location: infractores.php"); 
    }







?>