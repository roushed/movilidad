<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<div class="divppl">
 
    <div class="container">
    <?php 
            include "./seguridad.php";
            echo"<p>"; 
            echo "Ha entrado con el nombre de usuario: ".$_SESSION['usuario']." ";
            echo "<a href='./cierresesion.php'>Cerrar Sesion</a>"; 
            echo"</p>"; 
            
    ?>
        <div class="titulo">
        <h1>Gestión de Movilidad</h1>
        </div>

    <center><h3>Listado de Infractores</h3></center>
    
    <?php

    function eliminaContenido(){


        $ficheroborrar =fopen("noautorizados.txt", "w+");
        fwrite($ficheroborrar, "");
        fclose($ficheroborrar);

    }

    function encuentraMatricula($archivo, $cadena){
 
        
        if($archivo == "logistica.txt"){
            

            $fichero=fopen($archivo,'r');
            
            while(!feof($fichero)){
                $linea=fgets($fichero);
                $cadena_s=explode(" ",$linea);
                //echo $cadena_s[0]. "=".$cadena."<br>";

                if($cadena_s[0] == $cadena[0]){
                    
                    $date1=new DateTime($cadena[4]);
                    $date1v=$date1 -> format('H:i');
                    $date2=new DateTime("6:00");
                    $date2v=$date2 -> format('H:i');
                    $date3=new DateTime("11:00");
                    $date3v=$date3 -> format('H:i');

                    //echo $date1v."se encuentra entre".$date2v. "y".$date3v;

                    if($date1v < $date2v ||  $date1v > $date3v){
                        
                        //echo "Hay un infractorrr!!!!";
                        $finfractor=fopen('noautorizados.txt','a+');
                            
                        fwrite($finfractor, $cadena[0]." ".$cadena[1]." ".$cadena[2]." ".$cadena[3]." ".$cadena[4]." ".$cadena[5]."\n");
                                          
                        fclose($finfractor);

                        return true;
                        
                    }
                        return true;
                    

                }

            }

            return false;

            fclose($fichero);



            

        }else if($archivo == "residentesyhoteles.txt"){

 

            $fichero=fopen($archivo,'r');
                
            while(!feof($fichero)){
                $linea=fgets($fichero);
                $cadena_s=explode(" ",$linea);
                    
    
                if($cadena_s[0] == $cadena[0]){
                        
                    $date1=new DateTime($cadena[3]);
                    $date1v=$date1 -> format('Y-m-d');
                    $date2=new DateTime($cadena_s[2]);
                    $date2v=$date2 -> format('Y-m-d');
                    $date3=new DateTime($cadena_s[3]);
                    $date3v=$date3 -> format('Y-m-d');
    
                        //echo $date1v."se encuentra entre".$date2v. "y".$date3v;
    
                    if($date1v < $date2v ||  $date1v > $date3v){
                            
                            //echo "Hay un infractorrr!!!!";
                        $finfractor=fopen('noautorizados.txt','a+');
                                
                        fwrite($finfractor, $cadena[0]." ".$cadena[1]." ".$cadena[2]." ".$cadena[3]." ".$cadena[4]." ".$cadena[5]."\n");
                                              
                        fclose($finfractor);
    
                        return true;
                            
                    }
                        return true;
                        
    
                }
    
            }
    
                return false;
    
                fclose($fichero);


            

        }else{

            
            $fichero=fopen($archivo,'r');
                    
                while(!feof($fichero)){
                    $linea=fgets($fichero);
                    $cadena_s=explode(" ",$linea);
                    //echo $cadena_s[0]. "=".$cadena."<br>";
                    if($cadena_s[0] == $cadena[0]){
                            
                        return true;
    
                    }
    
                }
    
                return false;
    
            fclose($fichero);

        }
    }


    function imprimeTabla(){

        $fichero=fopen("noautorizados.txt","r");
        $datos="<table class='tinfractores'>";
        $datos.="<tr class='teaches'><th>Matricula</th><th>Nombre</th><th>Direccion</th><th>Fecha</th><th>Hora</th><th>Combustión</th></tr>";
            while(!feof($fichero)){
                $datos.="<tr>";
                $linea=fgets($fichero);
                $cadena_s=explode(" ",$linea);
                if(count($cadena_s) > 1){
                    for($i=0;$i<count($cadena_s);$i++){

                        $datos.="<td>".$cadena_s[$i]."</td>";
                        
                    }

                    $datos.="</tr>";
                }

            }
        $datos.="</table>";
        $datos.="<p><a href='./movilidad.php'>Atras</a></p>";
        fclose($fichero);

        echo $datos;


    }

        eliminaContenido();
    

        $lista_ficheros=array('vehiculosEMT.txt','servicios.txt','taxis.txt','residentesyhoteles.txt','logistica.txt');
        $fichero=fopen('vehiculos.txt','r');
        
        while(!feof($fichero)){
            $cuenta_false=0;
            $linea=fgets($fichero);
            $cadena_s=explode(" ",$linea);
            $cadena_trim=trim($cadena_s[5]); 

            if($cadena_trim != "electrico"){
                
                foreach($lista_ficheros as $lista){
                    
                    if(encuentraMatricula($lista, $cadena_s) == false){
                        $cuenta_false++;
                    }
                }
           

                if($cuenta_false == 5){
                
                    $finfractor=fopen('noautorizados.txt','a+');
                    
                    fwrite($finfractor, $cadena_s[0]." ".$cadena_s[1]." ".$cadena_s[2]." ".$cadena_s[3]." ".$cadena_s[4]." ".$cadena_s[5]."\n");                                         
                    fclose($finfractor);

                    
                }
            }
            

        }
        fclose($fichero);

        imprimeTabla();
        

    ?>
        </div>
    </div>
</body>
</html>