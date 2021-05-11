<?php
    $IdObra = $_POST["IdObra"];
    $correo = $_POST["correo"];
    $contrasenia = $_POST["contrasenia"];
    //echo $IdObra." - ".$correo." - ".$contrasenia;
    include('./conexion.php');
    $query = "select IdUsuarioCompra from tblUsuariosCompra where correo='".$correo."' and contrasenia='".$contrasenia."'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_array($result)){
            $IdUsuarioCompra=$row[0];
        }
        header("location:llenaDatos.php?IdObra=".$IdObra."&IdUsuarioCompra=".$IdUsuarioCompra);
    }else{
        header("location:checaUsuario.php?IdObra=".$IdObra."&fallo=1");
    }
?>