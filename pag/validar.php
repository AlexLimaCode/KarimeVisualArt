<?php

    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    //INICIO DE SESION

    session_start();
    $_SESSION['usuario']=$usuario;

    $conexion=mysqli_connect("localhost","root","","mibase");

   // $consulta="select * from usuarios where usuario='$usuario' and contrasenia='$contraseña'";

   $consulta="select * from usuarios  where usuario='$usuario' and contrasenia='$contraseña'";



    $resultado=mysqli_query($conexion,$consulta);

    $filas=mysqli_num_rows($resultado);

    if ($filas) {
        //EL HEADER ME MANDA A LA PAGINA CUANDO SI ESTA CORRECTO
        header("location:menuAdmin.html");
    } else {
        ?>
        <?php
        include("newlogin.php");
        ?>
        <h1 class="error"> ERROR EN LA AUTENTIFICACION<h1>
        <?php
    }
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>