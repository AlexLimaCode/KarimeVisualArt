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
                document.principal.accion.value="Limpiar"
                document.principal.nombre.value=""
				document.principal.contrasenia.value=""
                document.principal.usuario.value=""
				document.principal.acronimo.value=""
                Mensaje("ENTRO");
				document.principal.submit()
            }
            /*function extraer(id){
                alert("el valor del id es: "+id);
                document.principal.idFormulario.value=id
            }*/
		
		</script>
	</head>
    <?php 
    
    if (!Permiso("nUsuarios.php")) {    //funcion que verifica si el usuario tiene permiso al formulario.
        Mensaje("Ud. no tiene permisos para accesar al formulario Estatus de las Obras, verifique con el Administrador del Sistema (permisos.php)");
        echo "<script language=\"javascript\">";
        echo "window.location='principio.php'";
        echo "</script>";
    } 
    else {  // Significa que el usuario tiene permitido el acceso a este Formulario ?> 
        
	    <body>

        <?php
        $bandera=0;
        
        $IdUsuario = "";
        if(isset($_POST["IdUsuario"])){
            $IdUsuario = trim($_POST["IdUsuario"]); 
            if ($IdUsuario == ""){
                if(isset($_GET["IdUsuario"])){
                    $IdUsuario = $_GET["IdUsuario"];
                    if ($IdUsuario == ""){
                        $IdUsuario = "";
                    }
                }
            }
        }    
        else{ 
            if ($IdUsuario == ""){
                $IdUsuario = "";
            }
            if(isset($_GET["IdUsuario"])){ 
                $IdUsuario = $_GET["IdUsuario"];
                if ($IdUsuario == ""){
                    $IdUsuario = "";
                }
            }    
        }
        //Mensaje("El valor de id= ".$IdUsuario); 
        ?>
        <form name="principal" method="POST" action="nUsuarios.php">
            <input type="hidden" name="accion" value="">        <!-- es la accion que hara el usuario al presionar un boton -->
            <?php
                echo "<input type='hidden' name='IdUsuario' value='$IdUsuario'>    <!-- es el estatus de la tabla tblestatus -->"
                
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
                        if ($IdUsuario!=""){
                            conectar();
                            $result = mysqli_query($_SESSION["Conexion"], "select usuario, contrasenia, Nombre, acronimo from usuarios where IdUsuario=".$IdUsuario);
                            if (mysqli_num_rows($result)>0){
                                $row = mysqli_fetch_array($result);
                                echo "<input type='text' name='nombre' value='".$row['usuario']."'>";
                            ?>
                            <tr>
                                <td width="20%">Contraseña: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='contrasenia' value='".$row['contrasenia']."'>";
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Nombre: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='usuario' value='".$row['Nombre']."'>";
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Acronimo: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='acronimo' value='".$row['acronimo']."'>";
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
                                <td width="20%">Contraseña: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='contrasenia' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Nombre: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='usuario' value=''>";
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Acronimo: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='acronimo' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }else{  //QUE SOLO PUEDE CONSULTAR
                        Mensaje("Solo podras consultar");
                        if ($IdUsuario!=""){
                            conectar();
                            $result = mysqli_query($_SESSION["Conexion"], "select usuario, Nombre, acronimo from usuarios where IdUsuario=".$IdUsuario);
                            if (mysqli_num_rows($result)>0){
                                $row = mysqli_fetch_array($result);
                                echo "<input type='text' name='nombre' value='".$row['Nombre']."'>";
                            ?>
                            <tr>
                                <td width="20%">Nombre: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='usuario' value='".$row['Nombre']."'>";
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Acronimo: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='acronimo' value='".$row['acronimo']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <?php
                            }
                            mysqli_free_result($result);
                            Desconectar(); 
                        }else{
                            echo "<input type='text' name='nombre' value=''>";
                            ?>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Nombre: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='usuario' value=''>";
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Acronimo: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='acronimo' value=''>";
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
                    $IdUsuario = "";
                    if(isset($_POST["IdUsuario"])){
                        $IdUsuario = trim($_POST["IdUsuario"]); 
                        if ($IdUsuario == ""){
                            if(isset($_GET["IdUsuario"])){
                                $IdUsuario = $_GET["IdUsuario"];
                                if ($IdUsuario == ""){
                                    $IdUsuario = "";
                                }
                            }
                        }
                    }    
                    else{ 
                        if ($IdUsuario == ""){
                            $IdUsuario = "";
                        }
                        if(isset($_GET["IdUsuario"])){ 
                            $IdUsuario = $_GET["IdUsuario"];
                            if ($IdUsuario == ""){
                                $IdUsuario = "";
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
                        echo "<input class='btn btn-outline-primary' type='button' value='Eliminar' onClick='eliminar()'>";
                        echo "&nbsp;&nbsp;&nbsp;";
                        
                    }
                ?>     
				<input class="btn btn-outline-primary" type="button" value=" Limpiar" onClick="limpiar()">
            </div>
            </table>
            
        </form>

        <?php
			// ----------------------------------------
			//   aqui inicia el procedimiento en PHP
			//------------------------------------------
            $IdUsuario = "";
            $nId="";
            if(isset($_POST["IdUsuario"])){
                $IdUsuario = trim($_POST["IdUsuario"]); 
                if ($IdUsuario == ""){
                    if(isset($_GET["IdUsuario"])){
                        $IdUsuario = $_GET["IdUsuario"];
                        if ($IdUsuario == ""){
                            $IdUsuario = "";
                        }
                    }
                }
            }    
            else{ 
                if ($IdUsuario == ""){
                    $IdUsuario = "";
                }
                if(isset($_GET["IdUsuario"])){ 
                    $IdUsuario = $_GET["IdUsuario"];
                    if ($IdUsuario == ""){
                        $IdUsuario = "";
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
                    $contrasenia = $_POST["contrasenia"];
                    $acronimo = $_POST["acronimo"];
                    $nombresi = $_POST["usuario"];
                    

                    // Validamos los valores que traen los campos
					if ($nombre==""){
						Mensaje("Debe proporcionar el Nombre necesariamente !!!");
					}
					else{
                        conectar();
                        // procedemos hacer la actualización, puede ser alta o modificación
                        if ($nombre!="" && $IdUsuario!="") {   //QUIERE DECIR QUE SE JALO UNO QUE ESTA DESPLEGADO
                            $result2 = mysqli_query($_SESSION["Conexion"], "update usuarios set usuario='".$nombre."', contrasenia='".$contrasenia."', Nombre='".$nombresi."', acronimo='".$acronimo."' where IdUsuario=".$IdUsuario);
                            Mensaje("SE HAN ACTUALIZADO LOS DATOS!!!");
                            ?>
                            
                            <?php
                        }else{
							$result = mysqli_query($_SESSION["Conexion"], "select IdUsuario from usuarios where IdUsuario='$IdUsuario'");
                            if (mysqli_num_rows($result)>0) {
                                
                                Mensaje("Ya existe un registro");
                            }else{
                                $result3 = mysqli_query($_SESSION["Conexion"],"insert into usuarios (usuario,contrasenia,Nombre,acronimo) values ('".$nombre."','".$contrasenia."','".$nombresi."','".$acronimo."')");
                                $result4 = mysqli_query($_SESSION["Conexion"],"select IdUsuario from usuarios where Nombre='".$nombresi."'");
                                if(mysqli_num_rows($result4)>0){
                                    while($row=mysqli_fetch_array($result4)){
                                       $nId=$row[0];                                         
                                    }
                                }
                                for ($i=0; $i < 15; $i++) { 
                                    $result4 = mysqli_query($_SESSION["Conexion"],"insert into tblpermisos (idFormulario,idUsuario,tipoPermiso) values (".$i.",".$nId.",'C')");
                                }
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
						if ($nombre!="" && $IdUsuario!="") {   //QUIERE DECIR QUE SE JALO UNO QUE ESTA DESPLEGADO
                                for ($i=0; $i < 15; $i++) { 
                                    $result4 = mysqli_query($_SESSION["Conexion"],"delete from tblpermisos where idFormulario = ".$i." and IdUsuario='".$IdUsuario."'");
                                }
                                $result2 = mysqli_query($_SESSION["Conexion"], "delete from usuarios where IdUsuario='$IdUsuario'");
                                Mensaje("SE HA ELIMINADO EL REGISTRO !!!");
                        }	
                        
						Desconectar();
                    }?>
                    <script language="javascript"> 
                        limpiar(); 
                    </script>	
                    <?php
                                              	
                }

                if ($accion=="Consultar"){
                    $nombre = $_POST["nombre"];
                    if($nombre==""){
                        Mensaje("Debe proporcionar el Nombre necesariamente !!!");
                    }else{
                        $result = mysqli_query($_SESSION["Conexion"], "select IdUsuario from tblobrasarte  where NomObra='$nombre'");
                        if (mysqli_num_rows($result)>0) {
                            $row = mysqli_fetch_array($result);
                            $IdUsuario=$row['IdUsuario'];
                            
                            echo "<form name='principal' method='GET' action='permisos.php.php'>";
                                Mensaje("Ya existe un registro   !!!");
                                echo "<input type='hidden' name='IdUsuario' value='$IdUsuario'>";
                                Mensaje($IdUsuario);
                            echo "</form>";
                        }else{
                            Mensaje("No existe ningun registro con ese nombre !!!");
                        }
                        
                    }
                           
        
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
            if ($_SESSION["PermisoActualizar"] == "A"){
                $result = mysqli_query($_SESSION["Conexion"], "select IdUsuario, usuario, contrasenia, Nombre,  acronimo from usuarios order by IdUsuario");
                if (mysqli_num_rows($result)>0){
                    $titulos=array("No.","NOMBRE DE USUARIO.","CONTRASEÑA", "NOMBRE", "ACRONIMO");
                    CreaTabla("Usuarios",$result,$titulos,$inicio,"nUsuarios.php","inicio",$RegistrosXPagina,false);	
                    //EscribeBitacora(72, "comentario");			
                }
                else{
                    Mensaje("No existen Permisos de Arte dados de alta en la Base de Datos !!!");    
                }
            }else{
                $result = mysqli_query($_SESSION["Conexion"], "select IdUsuario, usuario, Nombre,  acronimo from usuarios order by IdUsuario");
                if (mysqli_num_rows($result)>0){
                    $titulos=array("No.","NOMBRE DE USUARIO.","NOMBRE", "ACRONIMO");
                    CreaTabla("Usuarios",$result,$titulos,$inicio,"nUsuarios.php","inicio",$RegistrosXPagina,false);	
                    //EscribeBitacora(72, "comentario");			
                }
                else{
                    Mensaje("No existen Permisos de Arte dados de alta en la Base de Datos !!!");    
                }
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