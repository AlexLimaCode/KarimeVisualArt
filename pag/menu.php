<!-- UNIVERSIDAD ANAHUAC   -->
  <!-- INGENIERIA EN SISTEMAS COMPUTACIONALES           -->
  <!-- Funciones en PHP                      -->
  <!-- Fecha de Elaboraci�n: ENERO 2021 -->
  <!-- Autor: ALEJANDRO LIMA MARTINEZ        -->
  <!-- Version 1.0                           -->
  <!-- Descripcion del Programa  :           -->
  <!-- Este programa unicamente construye el menu con base a los permisos asignados al usuario   --> 


  <html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Arte Visual</title>
    <link rel="stylesheet" href="../css/estilos.css" type="text/css">
    <link rel="stylesheet" href="../css/csshorizontalmenu.css" type="text/css"> 
    <!-- CSS Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<!-- Linkeo el css -->
		<link rel="stylesheet" href="../css/global.css" />
		<!-- CDN Font awesome -->
		<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
		/>
    <script type="text/javascript" src="../js/csshorizontalmenu.js"></script>  
</head>
<?php 
    
// La libreria ./js/csshorizontalmenu.js, abierta en el head, sirve para hacer visible e invisible las viñetas del menu, solo hace eso !!
// alex, modifica este css  para que le des estilo a tu menu
// <link rel="stylesheet" href="./css/csshorizontalmenu.css" type="text/css">

if (!Permiso("menuPrincipal.php")) {    //funcion que verifica si el usuario tiene permiso al menu.
    Mensaje("Ud. no tiene permisos para accesar a este Formulario, verifique con el Administrador de BORRAMEs (menuPrincipal.php)");
    echo "<script language=\"javascript\">";
    echo "window.location='inicio.php'";
    echo "</script>";
} 
else {  // Significa que el usuario tiene permitido el acceso a este Formulario ?> 
    
            
        <tr>
        <td width="70%" >   <!-- La primera columna donde se deplegará el menu --> 
    <!--     -->
   
        <div class="horizontalcssmenu" style="text-align:center; border:30px; padding:20px;">
            <ul id="cssmenu1">
            <?php   function DespliegaNodo($idFormulario,$desFormulario,$idUsuario,$Archivo){ // ojo esta es funcion recursiva
                        $result = mysqli_query($_SESSION["Conexion"],"select * from tblPermisos PU, tblFormularios F 
	                                                where F.idFormulario =PU.idFormulario and PU.idUsuario =".$idUsuario." and
				                                    F.idFormularioPadre = ".$idFormulario." order by F.Orden, DesFormulario");
                                                       
                        if (mysqli_num_rows($result)<=0){
                            if ((strtoupper($desFormulario) <> "SALIR") && (strtoupper($desFormulario) <> "CERRAR")){
		                        echo "<li><a href='".$Archivo."' target ='Contenido'>".$desFormulario."</a></li>";
	                        }  
	                        else{
		                         echo "<li><a href='".$Archivo."'>".$desFormulario."</a></li>";
		                    }  
                        }	
                        else{
	                        echo "<li><a href='#' class='padre'>".$desFormulario."</a>";
	                        echo "<ul>";
                            $i = 1;
	                         while($row=mysqli_fetch_array($result)){
	                            DespliegaNodo($row["idFormulario"],$row["DesFormulario"],$idUsuario,$row["Archivo"]);  // ojo: se vuelve a llamar la misma funcion
	                            $i++;
                            }
	                        echo "</ul>";		  
	                        echo "</li>";
                        }
                        mysqli_free_result($result); 
                    }

                    conectar();
                    $result = mysqli_query($_SESSION["Conexion"],"select * from tblPermisos PU, tblFormularios F 
	                                    where F.idFormulario =PU.idFormulario and PU.idUsuario =".$_SESSION["CveUsuarioSistema"]." and
                                        NivelJerarquico = 1 order by Orden, desFormulario");
                    if (mysqli_num_rows($result)<=0)
                        Mensaje("No existen permisos, verifique su cuenta y permisos !!!");
                    else{
                        $i = 1;
	                    while($row=mysqli_fetch_array($result)){
	                        DespliegaNodo($row["idFormulario"],$row["DesFormulario"],$_SESSION["CveUsuarioSistema"],$row["Archivo"]);  // ojo: se vuelve a llamar la misma funcion
	                         $i++;
                        }		  
                    }
                    mysqli_free_result($result);
	                    
                    Desconectar();
            ?>
            </ul>
        </div>
        </td>
        <td width="30%"> &nbsp; </td> <!-- para este renglon, esta columna estará vacia -->
        </tr>

    

<?php 
}  // esta llave cierra el ELSE, donde se valida si el usuario tiene acceso a este formulario
?>

<!-- Jquery -->
<script src="../js/jquery-3.5.0.min.js"></script>
<!-- Popper -->
<script src="../js/popper.min.js"></script>
<!-- JS Bootstrap -->
<script src="../js/bootstrap.min.js"></script>
</html>