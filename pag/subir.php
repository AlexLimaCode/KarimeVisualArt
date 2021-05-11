<?php

    //include("Funciones.php");

    // isset() Comprobar si una va2riable está definida.
    $conn=mysqli_connect("localhost","root","","mibase");
    if (isset($_POST['Guardar'])) {
        $imagen=$_FILES['imagen']['name'];  //CREO UNA VARIABLE PARA ACCEDER AL FILE Y GUARDAR SU NOMBRE, YA QUE EN EL INPUT LO PIDO
        $nombre = $_POST['titulo'];         //UNA VARIABLE PARA EL NOMBRE QUE ME DARA EL USUARIO
        $id = $_POST['id'];
        
        if (isset($imagen)&& $imagen !="") {
            $tipo = $_FILES['imagen']['type'];
            //PARA LA RUTA DE LA IMAGEN
            $temp = $_FILES['imagen']['tmp_name'];

            /*if (!(strpos($tipo,'jpg'))){
                $_SESSION['mensaje'] = 'solo archivos jpg';
                //LO MANDO A MI INDEX PA QUE LO ENVIE
                header('location:./prueba.php');
            }else {*/ //Si todo esta bien pues meto un insert en la tabla
                echo "nombre= ".$nombre." imagen= ".$imagen;
                $query = "Insert into tblimagenes(IdObra,RutaImagen,nombre) values('$id','$imagen', '$nombre')";
                echo " paso el query= ".$query;
                $resultado = mysqli_query($conn,$query);
                echo " resultad=".$resultado;
                if ($resultado) {
                    echo "entro al if";
                    //PASARLA A LA CARPETA IMAGENES NECESITO LA RUTA DEL ARCHIVO DE DONDE VIENE, LA RUTA DE MI CARPETA CON EL NONMBRE QUE LE PONDRE
                    move_uploaded_file($temp,'../images/obras/'.$imagen);
                    # MENSAJE A TRAVES DE SESION
                    $_SESSION['mensaje'] = 'se ha subido correctamente con el tipo: '.$tipo2;
                    
                    //HASTA AQUI LA SUBE A LA BD, AHORA NECESITO REGRESARLA AL INDEX PARA QUE SALGA EN EL FORMULARIO
                    header('location:./subir.php');

                }else {
                    echo "entro al else";   
                    $_SESSION['mensaje'] = 'error al subir';
                }
            //}
        }

    }
    echo "PUEDE CERRAR LA PESTAÑA";

?>