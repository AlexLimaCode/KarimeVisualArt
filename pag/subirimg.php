<?php

include('conexion.php');
session_start();
$_SESSION['id'];

 class subirImg{
    
    public function subirImagen($params){
            $id=$params;
            $_SESSION['id']=$id;
            return $id;
    }

 }

 //FUERA DE LA CLASE

 $id_final=$_SESSION['id'];
 echo"EL ID FINAL VALE ".$id_final;
 


?>