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
        
		<!-- Linkeo el css -->
		<link rel="stylesheet" href="../css/global.css" />
		<!-- CDN Font awesome -->
		<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
		/>
		<link rel="stylesheet" href="../css/estilos.css" type="text/css">
        <!-- CSS Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css"/>
		<?php include("Funciones.php"); ?>
		
        <script>
            function CreateWindow(Title, Width, Height,id) {
                //alert("title= "+Title);
                var htmlpage = " ";
                var win_opt = "toolbar=0, location=0, directories=0, status=0,";
                win_opt += "menubar=0, scrollbars=0, resizable=0, copyhistory=0,";
                win_opt += "width=" + Width + ",height=" + Height;
                
                // Crear una nueva ventana
                NewWindow = window.open("","Title",win_opt);
                
                // Generaci�n del contenido de la p�gina
                NewWindow.document.open();
                htmlpage += "<HTML><HEAD><TITLE>" + Title + "</TITLE>";
                htmlpage += "</HEAD><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>";
                htmlpage +=  "<link rel='stylesheet' href='../css/bootstrap.min.css' />";
                htmlpage +=  "<link rel='stylesheet' href='../css/global.css' />";
                htmlpage +=  "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'/>";
                htmlpage +=   "<link rel='stylesheet' href='../css/estilos.css' type='text/css'>";
                htmlpage += "<BODY>"; 
                htmlpage += "<div class='container'>";
                htmlpage +=    "<div class='row'>";
                htmlpage +=        "<div class='col-lg-4'>";
                htmlpage +=            "<h1 class='text-primary'>Subir imagen</h1>";
                htmlpage +=            "<form action='./subir.php' method='post' enctype='multipart/form-data'>";
                htmlpage +=                "<input type='hidden' name='id' value='"+Title+"'>";
                htmlpage +=                "<div class='form-group'>";
                htmlpage +=                    "<label for='my-input'>Seleccione una imagen</label>";
                htmlpage +=                     "<br><br>"
                htmlpage +=                    "<input id='my-input' type='file' name='imagen'>";
                htmlpage +=                "</div>";
                htmlpage +=                "<div class='form-group'>";
                htmlpage +=                    "<input id='my-input' class='form-control' type='hidden' name='titulo'>";
                htmlpage +=                "</div>";
                htmlpage +=                 "<input type='submit' value='Guardar' name='Guardar' class='btn btn-primary'>";
                htmlpage +=                 "<?php if (isset($_SESSION['mensaje'])) { ?>";
                htmlpage +=                 "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
                htmlpage +=                 "<strong><?php echo $_SESSION['mensaje']; ?></strong>";
                htmlpage +=                 "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                htmlpage +=                 "</div>";
                htmlpage +=                 "<?php session_unset();} ?>";
                htmlpage +=             "</form>";
                htmlpage +=         "</div>";
                htmlpage +=     "</div>";
                htmlpage += "</div>";
                htmlpage += "<HR><FORM>";
                htmlpage += "<INPUT id='my-input' class='form-control' Type='button' Value='Close' onClick='window.close()'>";
                htmlpage += "</FORM>";
                htmlpage += "</CENTER>";
                htmlpage += "</BODY></HTML>";
                NewWindow.document.write(htmlpage);
                NewWindow.document.close();

            }

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
                //document.principal.IdObra.value=""
				document.principal.submit()
            }

            function eliminar(){
				document.principal.accion.value="Eliminar"
				document.principal.submit()
            }
            
            function consultar(){
				document.principal.accion.value="Consultar"
                document.principal.IdObra.value=""
				document.principal.submit()
            }

            function limpiar(){
                document.principal.accion.value="Limpiar"
                document.principal.IdObra.value=""
				document.principal.nombre.value=""
				document.principal.submit()
            }
            function cargar(){
                document.principal.accion.value="cargar"
				document.principal.submit()
            }
            /*function extraer(id){
                alert("el valor del id es: "+id);
                document.principal.CveEstatus.value=id
            }*/
		
		</script>
	</head>
    <?php 
    
    if (!Permiso("registroObras.php")) {    //funcion que verifica si el usuario tiene permiso al formulario.
        Mensaje("Ud. no tiene permisos para accesar al formulario Estatus de las Obras, verifique con el Administrador del Sistema (registroObras.php)");
        echo "<script language=\"javascript\">";
        echo "window.location='principio.php'";
        echo "</script>";
    } 
    else {  // Significa que el usuario tiene permitido el acceso a este Formulario ?> 
        
	    <body>

        <?php
        $bandera=0;
        
        $IdObra = "";
        if(isset($_POST["IdObra"])){
            $IdObra = trim($_POST["IdObra"]); 
            if ($IdObra == ""){
                if(isset($_GET["IdObra"])){
                    $IdObra = $_GET["IdObra"];
                    if ($IdObra == ""){
                        $IdObra = "";
                    }
                }
            }
        }    
        else{ 
            if ($IdObra == ""){
                $IdObra = "";
            }
            if(isset($_GET["IdObra"])){ 
                $IdObra = $_GET["IdObra"];
                if ($IdObra == ""){
                    $IdObra = "";
                }
            }    
        }
        //Mensaje("El valor de id= ".$IdObra); 
        ?>
        <form name="principal" method="POST" action="registroObras.php">
            <input type="hidden" name="accion" value="">        <!-- es la accion que hara el usuario al presionar un boton -->
            <?php
                echo "<input type='hidden' name='IdObra' value='$IdObra'>    <!-- es el estatus de la tabla tblestatus -->"
                
            ?>
            <table width="100%">  <!-- tabla para poner el titulo  -->
            <tr>
                <td width="100%"> > > Obras de Arte < < </td> 
            </tr> 
            </table>

            <table width="100%">  <!-- tabla para poner los campos del Formulario  -->
			<tr>
                <td width="20%">Nombre de la Obra: </td>
                <td width="80%">
                    <?php
                    if ($_SESSION["PermisoActualizar"] == "A"){
                        if ($IdObra!=""){
                            conectar();
                            $result = mysqli_query($_SESSION["Conexion"], "select NomObra, DesObra, FechaObra, PrecioObra, NomEstatus, NomTipo from tblobrasarte a, 
                            tblestatus e, tbltiposobras t where a.CveTipo=t.CveTipo and a.CveEstatus=e.CveEstatus and IdObra=".$IdObra);
                            if (mysqli_num_rows($result)>0){
                                $row = mysqli_fetch_array($result);
                                echo "<input type='text' name='nombre' value='".$row['NomObra']."'>";
                            ?>
                            <tr>
                                <td width="20%">Descripcion de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='descripcion' value='".$row['DesObra']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaObra' value='".$row['FechaObra']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Precio de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='number' name='PrecioObra' value='".$row['PrecioObra']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Estatus de la Obra: </td>
                                <td>
                                <?php
                                    //MANDO UNA FUNCION QUE ME DE UN SELECT
                                    LlenaCombo("select NomEstatus from tblestatus",$row['NomEstatus'],"NomEstatus");
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Tipo de la Obra: </td>
                                <td>
                                <?php
                                    //MANDO UNA FUNCION QUE ME DE UN SELECT
                                    LlenaCombo("select NomTipo from tbltiposobras",$row['NomTipo'],"NomTipo");
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
                                <td width="20%">Descripcion de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='descripcion' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaObra' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Precio de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='number' name='PrecioObra' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Estatus de la Obra: </td>
                                <td>
                                <?php
                                    LlenaCombo("select NomEstatus from tblestatus","algo","NomEstatus");
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Tipo de la Obra: </td>
                                <td>
                                <?php
                                    //MANDO UNA FUNCION QUE ME DE UN SELECT
                                    LlenaCombo("select NomTipo from tbltiposobras","algo","NomTipo");
                                ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }else{  //QUE SOLO PUEDE CONSULTAR
                        Mensaje("Solo podras consultar");
                        if ($IdObra!=""){
                            conectar();
                            $result = mysqli_query($_SESSION["Conexion"], "select NomObra, DesObra, FechaObra, PrecioObra, NomEstatus, NomTipo from tblobrasarte a, 
                            tblestatus e, tbltiposobras t where a.CveTipo=t.CveTipo and a.CveEstatus=e.CveEstatus and IdObra=".$IdObra);
                            if (mysqli_num_rows($result)>0){
                                $row = mysqli_fetch_array($result);
                                echo "<input type='text' name='nombre' value='".$row['NomObra']."'>";
                            ?>
                            <tr>
                                <td width="20%">Descripcion de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='descripcion' value='".$row['DesObra']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaObra' value='".$row['FechaObra']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Precio de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='number' name='PrecioObra' value='".$row['PrecioObra']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Estatus de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='NomEstatus' value='".$row['NomEstatus']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Tipo de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='NomTipo' value='".$row['NomTipo']."'>";
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
                                <td width="20%">Descripcion de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='descripcion' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaObra' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Precio de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='number' name='PrecioObra' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Estatus de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='NomEstatus' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Tipo de la Obra: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='NomTipo' value=''>";
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
                    $IdObra = "";
                    if(isset($_POST["IdObra"])){
                        $IdObra = trim($_POST["IdObra"]); 
                        if ($IdObra == ""){
                            if(isset($_GET["IdObra"])){
                                $IdObra = $_GET["IdObra"];
                                if ($IdObra == ""){
                                    $IdObra = "";
                                }
                            }
                        }
                    }    
                    else{ 
                        if ($IdObra == ""){
                            $IdObra = "";
                        }
                        if(isset($_GET["IdObra"])){ 
                            $IdObra = $_GET["IdObra"];
                            if ($IdObra == ""){
                                $IdObra = "";
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
                        echo "<input type='button' class='btn btn-outline-primary' value='Eliminar' onClick='eliminar()'>";
                        echo "&nbsp;&nbsp;&nbsp;";
                        if ($IdObra!="") {
                            echo "<input class='btn btn-outline-primary' type='button' id='my-input' value='Cargar Imagenes' name='imagen' onClick='CreateWindow(".$IdObra.")'>";
                            echo "&nbsp;&nbsp;&nbsp;";
                        }
                        
                    }
                ?>     
                <!-- Los siguientes dos botones los pone para todos los usuarios tengan o no permisos para actualizar  -->   
                <input class="btn btn-outline-primary" type="hidden" value=" Consultar" onClick="consultar()">
				&nbsp;&nbsp;&nbsp;
				<input class="btn btn-outline-primary" type="button" value=" Limpiar" onClick="limpiar()">
            </div>
            </table>
            
        </form>

        <?php
			// ----------------------------------------
			//   aqui inicia el procedimiento en PHP
			//------------------------------------------
            $IdObra = "";
            if(isset($_POST["IdObra"])){
                $IdObra = trim($_POST["IdObra"]); 
                if ($IdObra == ""){
                    if(isset($_GET["IdObra"])){
                        $IdObra = $_GET["IdObra"];
                        if ($IdObra == ""){
                            $IdObra = "";
                        }
                    }
                }
            }    
            else{ 
                if ($IdObra == ""){
                    $IdObra = "";
                }
                if(isset($_GET["IdObra"])){ 
                    $IdObra = $_GET["IdObra"];
                    if ($IdObra == ""){
                        $IdObra = "";
                    }
                }    
            }
            //Mensaje($IdObra);
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
                    $FechaObra = $_POST["FechaObra"];
                    $PrecioObra = $_POST["PrecioObra"];
                    $NomEstatus = $_POST["NomEstatus"];
                    $NomTipo = $_POST["NomTipo"];
                    

                    // Validamos los valores que traen los campos
					if ($nombre==""){
						Mensaje("Debe proporcionar el Nombre necesariamente !!!");
					}
					else{
                        conectar();
                        // procedemos hacer la actualización, puede ser alta o modificación
                        //Mensaje($nombre);
                        //Mensaje($IdObra);
                        if ($nombre!="" && $IdObra!="") {   //QUIERE DECIR QUE SE JALO UNO QUE ESTA DESPLEGADO

                            // LO MANDO A UNA FUNCION QUE INDICA A DONDE DEBE DE HACERSE EL UPDATE CORRESPONDIENTE
                            UpdateObras($IdObra,$nombre,$descripcion,$FechaObra,$PrecioObra,$NomTipo,$NomEstatus);

                        }else{
							$result = mysqli_query($_SESSION["Conexion"], "select IdObra from tblobrasarte where NomObra='$nombre'");
                            if (mysqli_num_rows($result)>0) {
                                
                                Mensaje("Ya existe un registro   ");
                            }
							else{
                                Mensaje("No existe un registro con ese nombre, se dara de alta uno !!!");
                                                                
                                LoadObras($nombre,$descripcion,$FechaObra,$PrecioObra,$NomTipo,$NomEstatus);    
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
						if ($nombre!="" && $IdObra!="") {   //QUIERE DECIR QUE SE JALO UNO QUE ESTA DESPLEGADO
                            $bimagen = "Select IdImagen from tblobrasarte o, tblimagenes i where o.IdObra=i.IdObra and o.IdObra=".$IdObra;
                            $rimagen = mysqli_query($_SESSION["Conexion"],$bimagen);
                            if (mysqli_num_rows($rimagen)>0){
                                while ($row=mysqli_fetch_array($rimagen)){
                                    $bimagen = "delete from tblimagenes where IdImagen=".$row[0];
                                    $rimagen2 = mysqli_query($_SESSION["Conexion"],$bimagen);
                                }
                            }
                            
                            $query="delete from tblobrasarte where IdObra=".$IdObra;
                            //Mensaje($query);
                            $result2 = mysqli_query($_SESSION["Conexion"],$query) ;
                            Mensaje("SE HA ELIMINADO EL REGISTRO CON NOMBRE ".$nombre." !!!");
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
                        $result = mysqli_query($_SESSION["Conexion"], "select IdObra from tblobrasarte  where NomObra='$nombre'");
                        if (mysqli_num_rows($result)>0) {
                            $row = mysqli_fetch_array($result);
                            $IdObra=$row['IdObra'];
                            
                            echo "<form name='principal' method='GET' action='registroObras.php'>";
                                Mensaje("Ya existe un registro   !!!");
                                echo "<input type='hidden' name='IdObra' value='$IdObra'>";
                                Mensaje($IdObra);
                            echo "</form>";
                        }else{
                            Mensaje("No existe ningun registro con ese nombre !!!");
                        }
                        
                    }
                           
        
                }

                if ($accion=="cargar") {
                    $nombre = $_POST["nombre"];
                    
                    if ($nombre!="") {
                        Conectar();
                        Mensaje($IdObra);
                        $result = mysqli_query($_SESSION["Conexion"], "select IdImagen, NomObra, RutaImagen from tblobrasarte a, tblimagenes i where a.IdObra=i.IdObra and i.IdObra=".$IdObra." order by IdImagen");

                        if (mysqli_num_rows($result)>0){
                            $titulos=array("No.","Nombre de la obra", "Ruta de la Imagen");
                            TablaImagenes("IMAGENES",$result,$titulos,$inicio,"RegistroObras.php","inicio",$RegistrosXPagina,false);	
                            //EscribeBitacora(72, "comentario");			
                        }
                        else{
                            Mensaje("No existen Imagenes de esa obra !!!");
                            $titulos=array("No.","Nombre de la obra", "Ruta de la Imagen");
                            TablaImagenes("IMAGENES",$result,$titulos,$inicio,"RegistroObras.php","inicio",$RegistrosXPagina,false);  
                        }	
                        mysqli_free_result($result);
                        Desconectar();
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


            //LLAMAMOS LA FUNCION PARA SUBIR LAS IMAGENES
            if ($IdObra!="") {
                conectar();
                $result = mysqli_query($_SESSION["Conexion"], "select IdImagen, NomObra, RutaImagen from tblobrasarte a, tblimagenes i where a.IdObra=i.IdObra and i.IdObra=".$IdObra." order by IdImagen");
                $titulos=array("No.","Nombre de la obra", "Ruta de la Imagen");
                TablaImagenes("IMAGENES",$result,$titulos,$inicio,"RegistroObras.php","inicio",$RegistrosXPagina,false);	
                //EscribeBitacora(72, "comentario");			
                mysqli_free_result($result);
                Desconectar();
            }



            //Mensaje("valor de incio= ".$inicio);
            //  Hacemos la consulta, para despues desplegarla en la Funcion CreaTabla
            conectar();
            $result = mysqli_query($_SESSION["Conexion"], "select IdObra, NomObra, DesObra, FechaObra, PrecioObra, NomEstatus, NomTipo from tblobrasarte a, 
            tblestatus e, tbltiposobras t where a.CveTipo=t.CveTipo and a.CveEstatus=e.CveEstatus order by IdObra");
            if (mysqli_num_rows($result)>0){
                $titulos=array("No.","Nombre de la obra", "Descripcion", "Fecha", "Precio", "Estatus", "Tipo");
                 CreaTabla("Obras de Arte",$result,$titulos,$inicio,"RegistroObras.php","inicio",$RegistrosXPagina,false);	
                //EscribeBitacora(72, "comentario");			
            }
            else{
                Mensaje("No existen Estatus de Obras de Arte dados de alta en la Base de Datos !!!");    
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