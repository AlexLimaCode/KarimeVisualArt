 <!-- UNIVERSIDAD ANAHUAC   -->
  <!-- INGENIERIA EN SISTEMAS COMPUTACIONALES           -->
  <!-- Funciones en PHP                      -->
  <!-- Fecha de Elaboraci�n: ENERO 2021 -->
  <!-- Autor: ALEJANDRO LIMA MARTINEZ        -->
  <!-- Version 1.0                           -->
  <!-- Descripcion del Programa  :           -->
  <!-- Modulo para dar de alta los Estatus que pueden tener las Obras de Arte      --> 

  <?php
    session_start();  // la variable session se debe declarar antes de la etiqueta html session_start();
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Arte Visual</title>
        <!-- CSS Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<!-- Linkeo el css -->
		<link rel="stylesheet" href="../css/global.css" />
		<!-- CDN Font awesome -->
		<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
		/>
		<link rel="stylesheet" href="../css/estilos.css" type="text/css">
		<?php include("Funciones.php"); ?>
		
        <script>
			function cambia(siguiente, anterior){
			    //ESTA FUNCION ME PERMITE IR HACIA ADELANTE CUANDO EL USUARIO LE DA ENTER AL CAMPO
			    if ((event.keyCode==13) && (siguiente!="")){
				    x=eval("document.principal." + siguiente + ".focus()")
			    }
			    //ESTA FUNCION ME PERMITE IR HACIA ATRAS CUANDO EL USUARIO LE DA esc AL CAMPO
			    if((event.keyCode==27) && (anterior!="")){
				    x=eval("document.principal." + anterior + ".focus()")
			    }
            }
            
			function selecciona(xobjeto){
				x=eval("document.principal." + xobjeto + ".select()")
            }
            
			function actualizar(){
				document.principal.accion.value="Actualizar"
				document.principal.submit()
            }

            function eliminar(){
				document.principal.accion.value="Eliminar"
				document.principal.submit()
            }
            
            function consultar(){
				document.principal.accion.value="Consultar"
				document.principal.submit()
            }

            function limpiar(){
                document.principal.accion.value="Limpiar";
                document.principal.descripcion.value=""
				document.principal.nombre.value=""
				document.principal.submit()
            }
            /*function extraer(id){
                alert("el valor del id es: "+id);
                document.principal.idFormulario.value=id
            }*/
		
		</script>
	</head>
    <?php 
    
    if (!Permiso("permisos.php")) {    //funcion que verifica si el usuario tiene permiso al formulario.
        Mensaje("Ud. no tiene permisos para accesar al formulario Estatus de las Obras, verifique con el Administrador del Sistema (permisos.php)");
        echo "<script language=\"javascript\">";
        echo "window.location='principio.php'";
        echo "</script>";
    } 
    else {  // Significa que el usuario tiene permitido el acceso a este Formulario ?> 
        
	    <body>

        <?php
        $bandera=0;
        
        $idPermiso = "";
        if(isset($_POST["idPermiso"])){
            $idPermiso = trim($_POST["idPermiso"]); 
            if ($idPermiso == ""){
                if(isset($_GET["idPermiso"])){
                    $idPermiso = $_GET["idPermiso"];
                    if ($idPermiso == ""){
                        $idPermiso = "";
                    }
                }
            }
        }    
        else{ 
            if ($idPermiso == ""){
                $idPermiso = "";
            }
            if(isset($_GET["idPermiso"])){ 
                $idPermiso = $_GET["idPermiso"];
                if ($idPermiso == ""){
                    $idPermiso = "";
                }
            }    
        }
        //Mensaje("El valor de id= ".$idPermiso); 
        ?>
        <form name="principal" method="POST" action="permisos.php">
            <input type="hidden" name="accion" value="">        <!-- es la accion que hara el usuario al presionar un boton -->
            <?php
                echo "<input type='hidden' name='idPermiso' value='$idPermiso'>    <!-- es el estatus de la tabla tblestatus -->"
                
            ?>
            <table width="100%">  <!-- tabla para poner el titulo  -->
            <tr>
                <td width="100%"> > > Usuarios < < </td> 
            </tr> 
            </table>

            <table width="100%">  <!-- tabla para poner los campos del Formulario  -->
			<tr>
                <td width="20%">Nombre del usuario: </td>
                <td width="80%">
                    <?php
                    if ($_SESSION["PermisoActualizar"] == "A"){
                        if ($idPermiso!=""){
                            conectar();
                            $result = mysqli_query($_SESSION["Conexion"], "select Nombre, DesFormulario, tipoPermiso from tblpermisos p, 
                            tblformularios f, usuarios u where u.IdUsuario=p.IdUsuario and f.idFormulario=p.idFormulario and idPermiso=".$idPermiso);
                            if (mysqli_num_rows($result)>0){
                                $row = mysqli_fetch_array($result);
                                echo "<input type='text' name='nombre' value='".$row['Nombre']."'>";
                            ?>
                            <tr>
                                <td width="20%">Formulario: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='descripcion' value='".$row['DesFormulario']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Tipo de Permiso: </td>
                                <td>
                                <?php
                                    //MANDO UNA FUNCION QUE ME DE UN SELECT
                                    LlenaCombo("select distinct tipoPermiso from tblpermisos",$row['tipoPermiso'],"NomTipo");
                                ?>
                                </td>
                            </tr>
                            <?php
                            }
                            mysqli_free_result($result);
                            Desconectar(); 
                        }else{
                            echo "<input type='text' name='nombre' value=''>";
                            ?>
                            <tr>
                                <td width="20%">Formulario: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='descripcion' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Tipo de Permiso: </td>
                                <td>
                                <?php
                                    LlenaCombo("select distinct tipoPermiso from tblpermisos","A","NomTipo");
                                ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }else{  //QUE SOLO PUEDE CONSULTAR
                        Mensaje("Solo podras consultar");
                        if ($idPermiso!=""){
                            conectar();
                            $result = mysqli_query($_SESSION["Conexion"], "select Nombre, DesFormulario,tipoPermiso from tblpermisos p, 
                            tblformularios f, usuarios u where u.IdUsuario=p.IdUsuario and f.idFormulario=p.idFormulario and idPermiso=".$idPermiso);
                            if (mysqli_num_rows($result)>0){
                                $row = mysqli_fetch_array($result);
                                echo "<input type='text' name='nombre' value='".$row['Nombre']."'>";
                            ?>
                            <tr>
                                <td width="20%">Formulario: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='descripcion' value='".$row['DesFormulario']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Tipo de Permiso: </td>
                                <td>
                                <?php
                                    //MANDO UNA FUNCION QUE ME DE UN SELECT
                                    LlenaCombo("select tipoPermiso from tblpermisos",$row['tipoPermiso'],"NomTipo");
                                ?>
                                </td>
                            </tr>
                            <?php
                            }
                            mysqli_free_result($result);
                            Desconectar(); 
                        }else{
                            echo "<input type='text' name='nombre' value=''>";
                            ?>
                            <tr>
                                <td width="20%">Formulario: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='descripcion' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Tipo de Permiso: </td>
                                <td>
                                <?php
                                    LlenaCombo("select tipoPermiso from tblpermisos",'A',"NomTipo");
                                ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>    
            </tr>     
            </table>
          
            <table width="100%">  <!-- tabla para poner los botones del Formulario  -->
            <div>
                <?php
                    $idPermiso = "";
                    if(isset($_POST["idPermiso"])){
                        $idPermiso = trim($_POST["idPermiso"]); 
                        if ($idPermiso == ""){
                            if(isset($_GET["idPermiso"])){
                                $idPermiso = $_GET["idPermiso"];
                                if ($idPermiso == ""){
                                    $idPermiso = "";
                                }
                            }
                        }
                    }    
                    else{ 
                        if ($idPermiso == ""){
                            $idPermiso = "";
                        }
                        if(isset($_GET["idPermiso"])){ 
                            $idPermiso = $_GET["idPermiso"];
                            if ($idPermiso == ""){
                                $idPermiso = "";
                            }
                        }    
                    }
                    $pag="";
                    $RegistrosXPagina = 10;     // con esta variable controlamos cuantos registros queremos ver por pagina
                    if(isset($_POST["pag"])){
                        $pag = trim($_POST["pag"]); 
                        if ($pag == ""){
                            if(isset($_GET["pag"])){
                                $pag = $_GET["pag"];
                                if ($pag == ""){
                                    $pag = $RegistrosXPagina;
                                }
                            }
                        }
                    }    
                    else{ 
                        if ($pag == ""){
                            $pag = $RegistrosXPagina;
                        }
                        if(isset($_GET["pag"])){ 
                            $pag = $_GET["pag"];
                            if ($pag == ""){
                                $pag =$RegistrosXPagina;
                            }
                        }    
                    }
                    
                    $inicio = $pag - $RegistrosXPagina; 
                    if ($_SESSION["PermisoActualizar"] == "A") {   // con esto validamos que el usuario tiene permisos para actualizar en el Formulario
                        echo "<input class='btn btn-outline-primary' type='button' value='Actualizar' onClick='actualizar()'>";
                        echo "&nbsp;&nbsp;&nbsp;";
                        
                        
                    }
                ?>     
				<input class="btn btn-outline-primary" type="button" value="Limpiar" onClick="limpiar()">
            </div>
            </table>
            
        </form>

        <?php
			// ----------------------------------------
			//   aqui inicia el procedimiento en PHP
			//------------------------------------------
            $idPermiso = "";
            if(isset($_POST["idPermiso"])){
                $idPermiso = trim($_POST["idPermiso"]); 
                if ($idPermiso == ""){
                    if(isset($_GET["idPermiso"])){
                        $idPermiso = $_GET["idPermiso"];
                        if ($idPermiso == ""){
                            $idPermiso = "";
                        }
                    }
                }
            }    
            else{ 
                if ($idPermiso == ""){
                    $idPermiso = "";
                }
                if(isset($_GET["idPermiso"])){ 
                    $idPermiso = $_GET["idPermiso"];
                    if ($idPermiso == ""){
                        $idPermiso = "";
                    }
                }    
            }

            $accion=""; 
            if(isset($_POST["accion"])){   // validamos que la variable este definida, para que no truene la primera vez que entra
                $accion = trim($_POST["accion"]); 
                if ($accion == ""){
                        if(isset($_GET["accion"])){
                            $accion = $_GET["accion"];
                            if ($accion == ""){
                                $accion = "";
                            }
                        }
                    }                
                else{ 
                    if ($accion == ""){
                        $accion = "";
                    }
                    if(isset($_GET["accion"])){ 
                        $accion = $_GET["accion"];
                        if ($accion == ""){
                            $accion = "";
                        }
                    }    
                }

				//$accion = $_POST['accion'];   // es un campo de texto que nos indica la accion a realizar en el sistema
                								
				if ($accion=="Actualizar"){       
                    // Recojo el valor de los campos en el Formulario      
                    $nombre = $_POST["nombre"];
                    $descripcion = $_POST["descripcion"];
                    $NomTipo = $_POST["NomTipo"];
                    

                    // Validamos los valores que traen los campos
					if ($nombre==""){
						Mensaje("Debe proporcionar el Nombre necesariamente !!!");
					}
					else{
                        conectar();
                        // procedemos hacer la actualización, puede ser alta o modificación
                        if ($nombre!="" && $idPermiso!="") {   //QUIERE DECIR QUE SE JALO UNO QUE ESTA DESPLEGADO
                            if($NomTipo==1){
                                $NomTipo="A";
                            }else{
                                $NomTipo="C";
                            }
                            $result2 = mysqli_query($_SESSION["Conexion"], "update tblpermisos set tipoPermiso='$NomTipo' where idPermiso='$idPermiso'");
                            Mensaje("SE HAN ACTUALIZADO LOS DATOS, UNICAMENTE EL TIPO DE PERMISO !!!");

                        }else{
							$result = mysqli_query($_SESSION["Conexion"], "select idPermiso from tblpermisos where idPermiso='$idPermiso'");
                            if (mysqli_num_rows($result)>0) {
                                
                                Mensaje("Ya existe un registro   ");
                            }
                            mysqli_free_result($result);	  
                        }	
                        
						Desconectar();
                    }?>
                    <script language="javascript"> 
                        limpiar(); 
                    </script>	
                <?php
                }

                if ($accion=="Eliminar"){
                    // Recojo el valor de los campos en el Formulario      
                    $nombre = $_POST["nombre"];
                    

                    // Validamos los valores que traen los campos
					if ($nombre==""){
						Mensaje("Debe proporcionar el Nombre necesariamente !!!");
					}
					else{
                        conectar();
                        // procedemos hacer la actualización, puede ser alta o modificación
						if ($nombre!="" && $idPermiso!="") {   //QUIERE DECIR QUE SE JALO UNO QUE ESTA DESPLEGADO
                                $result2 = mysqli_query($_SESSION["Conexion"], "delete from tblpermisos where idPermiso='$idPermiso'");
                                Mensaje("SE HA ELIMINADO EL REGISTRO CON NOMBRE ".$nombre." !!!");
                        }	
                        
						Desconectar();
                    }?>
                    <script language="javascript"> 
                        limpiar(); 
                    </script>	
                    <?php
                                              	
                }
                if ($accion=="Limpiar"){
                    // borran los contenidos de las cajas de texto
                    
                }
            }
            
            //  con las siguientes lineas controlamos el paginado
            $pag="";
            $RegistrosXPagina = 10;     // con esta variable controlamos cuantos registros queremos ver por pagina
            if(isset($_POST["pag"])){
                $pag = trim($_POST["pag"]); 
                if ($pag == ""){
                    if(isset($_GET["pag"])){
                        $pag = $_GET["pag"];
                        if ($pag == ""){
                            $pag = $RegistrosXPagina;
                        }
                    }
                }
            }    
            else{ 
                if ($pag == ""){
                    $pag = $RegistrosXPagina;
                }
                if(isset($_GET["pag"])){ 
                    $pag = $_GET["pag"];
                    if ($pag == ""){
                        $pag =$RegistrosXPagina;
                    }
                }    
            }
            
            $inicio = $pag - $RegistrosXPagina;



            //Mensaje("valor de incio= ".$inicio);
            //  Hacemos la consulta, para despues desplegarla en la Funcion CreaTabla
            conectar();
            $result = mysqli_query($_SESSION["Conexion"], "select idPermiso, Nombre, DesFormulario, tipoPermiso from tblpermisos p, 
            tblformularios f, usuarios u where p.idFormulario=f.idFormulario and p.idUsuario=u.idUsuario order by idPermiso");
            if (mysqli_num_rows($result)>0){
                $titulos=array("No.","Nombre del usuario", "Formulario","Tipo de Permiso");
                 CreaTabla("Permisos",$result,$titulos,$inicio,"permisos.php","inicio",$RegistrosXPagina,false);	
                //EscribeBitacora(72, "comentario");			
            }
            else{
                Mensaje("No existen Permisos de Arte dados de alta en la Base de Datos !!!");    
            }	
            mysqli_free_result($result);
            Desconectar(); 
            
		?>
        <!-- Jquery -->
        <script src="../js/jquery-3.5.0.min.js"></script>
        <!-- Popper -->
        <script src="../js/popper.min.js"></script>
        <!-- JS Bootstrap -->
        <script src="../js/bootstrap.min.js"></script>
        </body>
    <?php 
    }  // esta llave cierra el ELSE, donde se valida si el usuario tiene acceso a este formulario
    ?> 
</html>