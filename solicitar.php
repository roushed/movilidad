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
    

    <?php
        if(isset($_POST['selecciona'])){

            $selectemt=$_POST['tipov'] == "emt" ? "SELECTED" : "";
            $selectaxis=$_POST['tipov'] == "taxis" ? "SELECTED" : "";
            $selectlogistica=$_POST['tipov'] == "logistica" ? "SELECTED" : "";
            $selectservicio=$_POST['tipov'] == "servicio" ? "SELECTED" : "";
            $selectryhoteles=$_POST['tipov'] == "ryhoteles" ? "SELECTED" : "";
        }

        if(isset($_POST['registrar'])){

            $selectemt=$_POST['valtipov'] == "emt" ? "SELECTED" : "";
            $selectaxis=$_POST['valtipov'] == "taxis" ? "SELECTED" : "";
            $selectlogistica=$_POST['valtipov'] == "logistica" ? "SELECTED" : "";
            $selectservicio=$_POST['valtipov'] == "servicio" ? "SELECTED" : "";
            $selectryhoteles=$_POST['valtipov'] == "ryhoteles" ? "SELECTED" : "";
        }


       

    ?>
    <div class="divppl">
        <div class="container">
            <div class="titulo">
                <h1>Gestión de Movilidad</h1>
            </div>
        <h3>Registrar vehiculo</h3>

        <form method="post" action="solicitar.php" id="formtipo">
        
        <select name="tipov" id="tipov">
            <option value="emt" <?php if(isset($_POST['selecciona'])) {echo $selectemt;} if(isset($_POST['registrar'])) {echo $selectemt;} ?>>EMT</option>
            <option value="taxis" <?php if(isset($_POST['selecciona'])) {echo $selectaxis;} if(isset($_POST['registrar'])) {echo $selectaxis;} ?>>Taxis</option>
            <option value="logistica" <?php if(isset($_POST['selecciona'])) {echo $selectlogistica;} if(isset($_POST['registrar'])) {echo $selectlogistica;} ?>>Logistica</option>
            <option value="servicio" <?php if(isset($_POST['selecciona'])) {echo $selectservicio;} if(isset($_POST['registrar'])) {echo $selectservicio;} ?>>Servicios</option>
            <option value="ryhoteles" <?php if(isset($_POST['selecciona'])) {echo $selectryhoteles;} if(isset($_POST['registrar'])) {echo $selectryhoteles;} ?>>Residente y Hoteles</option>
        </select>
        <input type="submit" value="Seleccionar" name="selecciona" id="selecciona">
       
    </form>

    <?php
         if(isset($_POST['registrar'])){
            
            $valtipo=$_POST['valtipov'];
          
            function escribeFichero($archivo){

                $matricula=$_POST['matricula'];
                $entidad=$_POST['entidad'];
                $correcto=true;

                if(empty($matricula)){
                    
                    $correcto=false;
                    
                }

                if(empty($entidad)){

                    $correcto=false;

                }

                if ($correcto){                 
                    $fichero=fopen($archivo,'a+');
                    if(!$fichero){

                        die("No se encuentra el fichero");
                    }
                    $matriculab=str_replace(" ","-",$matricula);
                    $entidadb=str_replace(" ","_",$entidad);
                    fwrite($fichero, $matriculab." ".$entidadb."\n");
                    fclose($fichero);
                    echo "<p>Se ha escrito correctamente</p>";
                }else{

                    echo "<p><font color='red'>*Alguno de los campos se encuentran vacio</font></p>";
                    
                }

            }

            function escribeFicheroRyh($archivo){

                $msgfecha=false;
                $msgerror=false;
                $correcto=true;
                $matricula=$_POST['matricula'];
                $direccion=$_POST['direccion'];
                $fechai=$_POST['fechai'];
                $fechaf=$_POST['fechaf'];
                $date1=new DateTime($fechai);
                $datei=$date1 -> format('Y/m/d');
                $date2=new DateTime($fechaf);
                $datef=$date2 -> format('Y/m/d');
                  
                
                if(!empty($_POST['permiso'])){

                    $fpermiso=$_POST['permiso'];
                
                    foreach($fpermiso as $valor){
                        $permiso=$valor;
                    }
                }else{
                  
                    $msgerror=true;
                    $correcto=false;
                }
                //$permiso="";

                if(!empty($fpermiso)){
                   
                }

                if(empty($matricula) || empty($direccion) || empty($fechai) || empty($fechaf)){
                   
                    $msgerror=true;                
                    $correcto=false;
                }

                if($datei > $datef){
                   
                    $msgfecha=true;
                    $correcto=false;

                }


                if(is_uploaded_file($_FILES['justificante']['tmp_name'])){
                        
                    if($_FILES['justificante']['type'] == "application/pdf"){
                            
                    }else{

                        $correcto=false;
                        echo "<p>*El Formato invalido, solo admite formato pdf</p>";
                    }
                        
                }
                    
                
                if($correcto){
                        
                    $fichero=fopen($archivo,'a+');
                    if(!$fichero){

                        die("No se encuentra el fichero");
                    }
                        $matriculab=str_replace(" ","-",$matricula);
                        $direccionb=str_replace(" ","_",$direccion);
                        fwrite($fichero, $matriculab." ".$direccionb." ".$fechai." ".$fechaf." ".$permiso."\n");
                        fclose($fichero);
                        echo "<p>Se ha escrito correctamente</p>";


                        if(is_uploaded_file($_FILES['justificante']['tmp_name'])){
                
                            $carpeta="./img";
                            if(!is_dir($carpeta)){
            
                                echo "No se ha encontrado la carpeta";
                            }else{
                                
                                $archivo=$_FILES['justificante']['name'];
                                $idarchivo=time();
                                $archivo_completo=$idarchivo."-".$archivo;
                                $ruta_completa=$carpeta."/".$archivo_completo;
                                move_uploaded_file($_FILES['justificante']['tmp_name'], $ruta_completa);
                                //echo "Se ha subido el fichero correctamente en la carpeta /img";
                                
                            }
                     
                        }
                            
                }else{
                        
                    if($msgerror){
                        echo "<p><font color='red'>*Alguno de los campos se encuentra vacio</font></p>";
                    }

                    if($msgfecha){
                        echo "<p><font color='red'>*La fecha inicial es superior a la fecha final</font></p>";
                    }
  
                }
          

            }
            

            switch ($valtipo) {
                case "emt":
                    //echo "Ha seleciconad emt";
                    escribeFichero("vehiculosEMT.txt");
                    break;
                case "taxis":
                    //echo "Ha seleccionado taxi";
                    escribeFichero("taxis.txt");
                    break;
                case "logistica":
                    //echo "Ha seleccionado logistica";
                    escribeFichero("logistica.txt");
                    break;
                case "servicio":
                    //echo "Ha seleccionado servicio";
                    escribeFichero("servicios.txt");
                    break;

                case "ryhoteles":
                    //echo "Ha seleccionado residente y hoteles";
                    escribeFicheroRyh('residentesyhoteles.txt');
                    break;
            }
         }

    ?>
   
 

    <?php
       if(isset($_POST['selecciona'])){

            $tipo=$_POST['tipov'];
            $msgmatricula="";

            if($tipo == "emt" ||  $tipo == "taxis" || $tipo == "logistica" || $tipo == "servicio"){

                echo "<p><b>Se cargará el siguiente formulario:</b></p>";

                $formulario="<div class='formula'>";
                $formulario.="<form method='post' action='solicitar.php' id='formdatos'>";
                $formulario.="<p>";
                $formulario.="<p><input type='hidden' value='$tipo' id='valtipov' name='valtipov'></p>";
                $formulario.="<p><label>Matricula:</label><input type='text' name='matricula'></p>";
                $formulario.="<p><label>Entidad:</label><input type='text' name='entidad'></p>";
                $formulario.="<p><input type='submit' value='Registrar' name='registrar'></p>";
                $formulario.="</form>";
                $formulario.="</p>";
                $formulario.="</div>";
             

                echo $formulario;

            }else if($tipo =="ryhoteles"){

                echo "<p><b>Se cargará el siguiente formulario:</b></p>";


                $formulario="<div class='formula'>";
                $formulario.="<form method='post' action='solicitar.php' enctype='multipart/form-data'>";
                $formulario.="<p><input type='hidden' value='$tipo' id='valtipov' name='valtipov'></p>";
                $formulario.="<p>";
                $formulario.="<label>Matricula:</label><input type='text' name='matricula'>";
                $formulario.="<label>Permiso:</label>";
                $formulario.="<select multiple size='2' name='permiso[]'>";
                $formulario.="<option value='residente'>Residente</option>";
                $formulario.="<option value='hotel'>Hotel</option>";
                $formulario.="</select>";
                $formulario.="</p>";     
                $formulario.="<p>";
                $formulario.="<p>";
                $formulario.="<label>Fecha inicial:</label><input type='date' name='fechai'>";
                $formulario.="<label>Fecha final:</label><input type='date' name='fechaf'>";
                $formulario.="</p>";
                $formulario.="<p><label>Direccion:</label><input type='text' name='direccion'></p>";
                $formulario.="<p><label>Justificante:</label><input type='file' name='justificante'></p>";
                $formulario.="<p>";
                $formulario.="<input type='submit' value='Registrar' name='registrar'>";     
                $formulario.="</p>";
                $formulario.="</form>";
                $formulario.="</div>";
              
                echo $formulario;
                
            }
        
       }

    ?>
    <p><a href="./movilidad.php">Atras</a></p>
    </div>
    </div>
    
 
</body>
</html>