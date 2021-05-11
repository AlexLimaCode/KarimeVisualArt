<?php

    $IdObra = $_POST['IdObra'];
    $nombre = $_POST['name'];
    $apellidop = $_POST['apep'];
    $apellidom = $_POST['apem'];      
    $correo = $_POST['mail'];         
    $telefono = $_POST['tel'];           
    $direc = $_POST['dir'];
    $numero = $_POST['num'];
    $cp = $_POST['cp'];
    $contrasenia = $_POST['contrasenia'];
    include('./conexion.php');
    $query = "insert into tblusuarioscompra (nombre, aPaterno, aMaterno, correo, telefono, direccion, numero, cp, contrasenia) values ('".$nombre."','".$apellidop."','".$apellidom."','".$correo."',".$telefono.",'".$direc."',".$numero.",".$cp.",'".$contrasenia."')";
    $result = mysqli_query($conn,$query);
    $query = "select IdUsuarioCompra from tblusuarioscompra where correo='".$correo."'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0){
        header("location:checaUsuario.php?IdObra=".$IdObra."&fallo=2");
    }else{
        header("location:checaUsuario.php?IdObra=".$IdObra."&fallo=1");
    }

?>