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
                
                var htmlpage = " ";
                var win_opt = "toolbar=0, location=0, directories=0, status=0,";
                win_opt += "menubar=0, scrollbars=0, resizable=0, copyhistory=0,";
                win_opt += "width=" + Width + ",height=" + Height;
                
                // Crear una nueva ventana
                NewWindow = window.open("","Title",win_opt);
                
                // Generaci�n del contenido de la p�gina
                NewWindow.document.open();
                htmlpage += "<HTML><HEAD><TITLE>" + Title + "</TITLE>";
                htmlpage += "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>";
                htmlpage += "<meta charset='UTF-8'/>";
                htmlpage +=  "<link rel='stylesheet' href='../css/bootstrap.min.css' />";
                htmlpage +=  "<link rel='stylesheet' href='../css/global.css' />";
                htmlpage +=  "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'/>";
                htmlpage +=   "<link rel='stylesheet' href='../css/estilos.css' type='text/css'>";
                htmlpage += "</HEAD>";
                htmlpage += "<BODY>";
                htmlpage += "<form action='muestraRecibo.php' method='post'>";
                htmlpage += "<input type='hidden' name='IdRecibo' class='btn btn-outline-primary' value='"+Title+"'>";
                htmlpage += "<br><br><div class='container text-center'>";
                htmlpage += "<p><input class='btn btn-primary' type='submit' value='LEER PDF' /></p><div class='alert alert-danger' role='alert'>DALE CLICK AL BOTON PARA VISUALIZAR EL PDF</div></div>";
                htmlpage += "</form>";
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
                document.principal.IdRecibo.value=""
				document.principal.submit()
            }

            function eliminar(){
				document.principal.accion.value="Eliminar"
				document.principal.submit()
            }
            
            function consultar(){
				document.principal.accion.value="Consultar"
                document.principal.IdRecibo.value=""
				document.principal.submit()
            }

            function limpiar(){
                document.principal.accion.value="Limpiar"
                document.principal.IdRecibo.value=""
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
    
    if (!Permiso("recibos.php")) {    //funcion que verifica si el usuario tiene permiso al formulario.
        Mensaje("Ud. no tiene permisos para accesar al formulario Estatus de las Obras, verifique con el Administrador del Sistema (recibos.php)");
        echo "<script language=\"javascript\">";
        echo "window.location='principio.php'";
        echo "</script>";
    } 
    else {  // Significa que el usuario tiene permitido el acceso a este Formulario ?> 
        
	    <body>

        <?php
        $bandera=0;
        
        $IdRecibo = "";
        if(isset($_POST["IdRecibo"])){
            $IdRecibo = trim($_POST["IdRecibo"]); 
            if ($IdRecibo == ""){
                if(isset($_GET["IdRecibo"])){
                    $IdRecibo = $_GET["IdRecibo"];
                    if ($IdRecibo == ""){
                        $IdRecibo = "";
                    }
                }
            }
        }    
        else{ 
            if ($IdRecibo == ""){
                $IdRecibo = "";
            }
            if(isset($_GET["IdRecibo"])){ 
                $IdRecibo = $_GET["IdRecibo"];
                if ($IdRecibo == ""){
                    $IdRecibo = "";
                }
            }    
        }
        ?>
        <form name="principal" method="POST" action="recibos.php">
            <input type="hidden" name="accion" value="">        <!-- es la accion que hara el usuario al presionar un boton -->
            <?php
                echo "<input type='hidden' name='IdRecibo' value='$IdRecibo'>    <!-- es el estatus de la tabla tblestatus -->"
                
            ?>
            <table width="100%">  <!-- tabla para poner el titulo  -->
            <tr>
                <td width="100%"> > > Obras de Arte < < </td> 
            </tr> 
            </table>

            <table width="100%">  <!-- tabla para poner los campos del Formulario  -->
			<tr>
                <td width="20%">Nombre del Recibo: </td>
                <td width="80%">
                    <?php
                    if ($_SESSION["PermisoActualizar"] == "A"){
                        if ($IdRecibo!=""){
                            conectar();
                            $result = mysqli_query($_SESSION["Conexion"], "select IdRecibo, DesEstatus, MontoTotal, FechaEmision, FechaPago, FechaValidacion, FechaCancelacion, Nombre, Paterno, Materno, Correo, Telefono from tblrecibos a, 
                            tblestatusrecibo e where a.IdEstatus=e.IdEstatus and IdRecibo=".$IdRecibo);
                            if (mysqli_num_rows($result)>0){
                                $row = mysqli_fetch_array($result);
                                echo "<input type='text' name='nombre' value='".$row['IdRecibo']."'>";
                            ?>
                            <tr>
                                <td width="20%">Estatus del Recibo: </td>
                                <td>
                                <?php
                                    //echo "<input type='text' name='descripcion' value='".$row['DesEstatus']."'>";
                                    //MANDO UNA FUNCION QUE ME DE UN SELECT
                                    LlenaCombo("select DesEstatus from tblestatusrecibo",$row['DesEstatus'],"DesEstatus");
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Monto del Recibo: </td>
                                <td>
                                <?php
                                    echo "<input type='number' name='MontoTotal' value='".$row['MontoTotal']."'>";
                                ?>
                                </td>
                            </tr>
                            
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Emision: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaEmision' value='".$row['FechaEmision']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Pago: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaPago' value='".$row['FechaPago']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Validacion: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaValidacion' value='".$row['FechaValidacion']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Cancelacion: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaCancelacion' value='".$row['FechaCancelacion']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Nombre del Comprador: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='name' value='".$row['Nombre']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Apellido Paterno: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Paterno' value='".$row['Paterno']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Apellido Materno: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Materno' value='".$row['Materno']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Correo: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Correo' value='".$row['Correo']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Telefono: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Telefono' value='".$row['Telefono']."'>";
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
                                <td width="20%">Estatus del Recibo: </td>
                                <td>
                                <?php
                                    //echo "<input type='text' name='descripcion' value='".$row['DesEstatus']."'>";
                                    //MANDO UNA FUNCION QUE ME DE UN SELECT
                                    LlenaCombo("select DesEstatus from tblestatusrecibo","algo","DesEstatus");
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Monto del Recibo: </td>
                                <td>
                                <?php
                                    echo "<input type='number' name='MontoTotal' value=''>";
                                ?>
                                </td>
                            </tr>
                            
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Emision: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaEmision' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Pago: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaPago' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Validacion: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaValidacion' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Cancelacion: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaCancelacion' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Nombre del Comprador: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='name' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Apellido Paterno: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Paterno' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Apellido Materno: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Materno' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Correo: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Correo' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Telefono: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Telefono' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }else{  //QUE SOLO PUEDE CONSULTAR
                        Mensaje("Solo podras consultar");
                        if ($IdRecibo!=""){
                            conectar();
                            $result = mysqli_query($_SESSION["Conexion"], "select IdRecibo, DesEstatus, MontoTotal, FechaEmision, FechaPago, FechaValidacion, FechaCancelacion, Nombre, Paterno, Materno, Correo, Telefono from tblrecibos a, 
                            tblestatusrecibo e, where a.IdEstatus=e.IdEstatus and IdRecibo=".$IdRecibo);
                            if (mysqli_num_rows($result)>0){
                                $row = mysqli_fetch_array($result);
                                echo "<input type='text' name='nombre' value='".$row['IdRecibo']."'>";
                            ?>
                            <tr>
                                <td width="20%">Estatus del Recibo: </td>
                                <td>
                                <?php
                                    //echo "<input type='text' name='descripcion' value='".$row['DesEstatus']."'>";
                                    //MANDO UNA FUNCION QUE ME DE UN SELECT
                                    LlenaCombo("select DesEstatus from tblestatusrecibo",$row['DesEstatus'],"DesEstatus");
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Monto del Recibo: </td>
                                <td>
                                <?php
                                    echo "<input type='number' name='MontoTotal' value='".$row['MontoTotal']."'>";
                                ?>
                                </td>
                            </tr>
                            
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Emision: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaEmision' value='".$row['FechaEmision']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Pago: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaPago' value='".$row['FechaPago']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Validacion: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaValidacion' value='".$row['FechaValidacion']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Cancelacion: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaCancelacion' value='".$row['FechaCancelacion']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Nombre del Comprador: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='name' value='".$row['Nombre']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Apellido Paterno: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Paterno' value='".$row['Paterno']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Apellido Materno: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Materno' value='".$row['Materno']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Correo: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Correo' value='".$row['Correo']."'>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Telefono: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Telefono' value='".$row['Telefono']."'>";
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
                                <td width="20%">Estatus del Recibo: </td>
                                <td>
                                <?php
                                    //echo "<input type='text' name='descripcion' value='".$row['DesEstatus']."'>";
                                    //MANDO UNA FUNCION QUE ME DE UN SELECT
                                    LlenaCombo("select DesEstatus from tblestatusrecibo",$row['DesEstatus'],"DesEstatus");
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Monto del Recibo: </td>
                                <td>
                                <?php
                                    echo "<input type='number' name='MontoTotal' value=''>";
                                ?>
                                </td>
                            </tr>
                            
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Emision: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaEmision' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Pago: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaPago' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Validacion: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaValidacion' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Fecha de Cancelacion: </td>
                                <td>
                                <?php
                                    echo "<input type='date' name='FechaCancelacion' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Nombre del Comprador: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='name' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Apellido Paterno: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Paterno' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Apellido Materno: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Materno' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Correo: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Correo' value=''>";
                                ?>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <tr>
                                <td width="20%">Telefono: </td>
                                <td>
                                <?php
                                    echo "<input type='text' name='Telefono' value=''>";
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
                    $IdRecibo = "";
                    if(isset($_POST["IdRecibo"])){
                        $IdRecibo = trim($_POST["IdRecibo"]); 
                        if ($IdRecibo == ""){
                            if(isset($_GET["IdRecibo"])){
                                $IdRecibo = $_GET["IdRecibo"];
                                if ($IdRecibo == ""){
                                    $IdRecibo = "";
                                }
                            }
                        }
                    }    
                    else{ 
                        if ($IdRecibo == ""){
                            $IdRecibo = "";
                        }
                        if(isset($_GET["IdRecibo"])){ 
                            $IdRecibo = $_GET["IdRecibo"];
                            if ($IdRecibo == ""){
                                $IdRecibo = "";
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
            $IdRecibo = "";
            if(isset($_POST["IdRecibo"])){
                $IdRecibo = trim($_POST["IdRecibo"]); 
                if ($IdRecibo == ""){
                    if(isset($_GET["IdRecibo"])){
                        $IdRecibo = $_GET["IdRecibo"];
                        if ($IdRecibo == ""){
                            $IdRecibo = "";
                        }
                    }
                }
            }    
            else{ 
                if ($IdRecibo == ""){
                    $IdRecibo = "";
                }
                if(isset($_GET["IdRecibo"])){ 
                    $IdRecibo = $_GET["IdRecibo"];
                    if ($IdRecibo == ""){
                        $IdRecibo = "";
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
                    $DesEstatus = $_POST["DesEstatus"];
                    $FechaEmision = $_POST["FechaEmision"];
                    $MontoTotal = $_POST["MontoTotal"];
                    $FechaPago = $_POST["FechaPago"];
                    $FechaValidacion = $_POST["FechaValidacion"];
                    $FechaCancelacion = $_POST["FechaCancelacion"];
                    $name = $_POST["name"];
                    $Paterno = $_POST["Paterno"];
                    $Materno = $_POST["Materno"];
                    $Correo = $_POST["Correo"];
                    $Telefono = $_POST["Telefono"];
                    

                    // Validamos los valores que traen los campos
					if ($nombre==""){
						Mensaje("Debe proporcionar el Nombre de Recibo necesariamente !!!");
					}
					else{
                        conectar();
                        // procedemos hacer la actualización, puede ser alta o modificación
                        if ($nombre!="" && $IdRecibo!="") {   //QUIERE DECIR QUE SE JALO UNO QUE ESTA DESPLEGADO
                            // LO MANDO A UNA FUNCION QUE INDICA A DONDE DEBE DE HACERSE EL UPDATE CORRESPONDIENTE
                            UpdateRecibos($IdRecibo,$nombre,$DesEstatus,$FechaEmision,$MontoTotal,$FechaPago,$FechaValidacion,$FechaCancelacion,$name,$Paterno,$Materno,$Correo,$Telefono);

                        }else{
							$result = mysqli_query($_SESSION["Conexion"], "select IdRecibo from tblrecibos where IdRecibo='$nombre'");
                            if (mysqli_num_rows($result)>0) {
                                UpdateRecibos($IdRecibo,$nombre,$DesEstatus,$FechaEmision,$MontoTotal,$FechaPago,$FechaValidacion,$FechaCancelacion,$name,$Paterno,$Materno,$Correo,$Telefono);
                                
                            }
							else{
                                //AQUI NO SE PUEDEN GENERAR RECIBOS INDEPENDIENTES A LOS DE LA PAGINA
                                Mensaje("No existe un Recibo con ese nombre");   
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
						Mensaje("Debe proporcionar el Nombre de Recibo necesariamente !!!");
					}
					else{
                        conectar();
                        // procedemos hacer la actualización, puede ser alta o modificación
						if ($nombre!="" && $IdRecibo!="") {   //QUIERE DECIR QUE SE JALO UNO QUE ESTA DESPLEGADO
                                $result2 = mysqli_query($_SESSION["Conexion"], "delete from tblrecibos where IdRecibo='$IdRecibo'");
                                Mensaje("SE HA ELMIMIDAO EL RECIBO CON NOMBRE ".$nombre." !!!");
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
                        $result = mysqli_query($_SESSION["Conexion"], "select IdRecibo from tblrecibos  where IdRecibo='$nombre'");
                        if (mysqli_num_rows($result)>0) {
                            $row = mysqli_fetch_array($result);
                            $IdRecibo=$row['IdRecibo'];
                            
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
            $result = mysqli_query($_SESSION["Conexion"], "select IdRecibo,IdRecibo,  DesEstatus, MontoTotal, FechaEmision, FechaPago, FechaValidacion, FechaCancelacion, Nombre, Paterno, Materno, Correo, Telefono from tblrecibos a, 
            tblestatusrecibo e where a.IdEstatus=e.IdEstatus order by IdRecibo");
            if (mysqli_num_rows($result)>0){
                $titulos=array("No.","Nombre del Recibo", "Estatus del Recibo", "Monto del Recibo", "Fecha de Emision", "Fecha de Pago", "Fecha de Validacion", "Fecha de Cancelacion", "Nombre del Cliente", "Apellido", "Materno", "Correo", "Telefono");
                 CreaTablaRecibos("Recibos",$result,$titulos,$inicio,"recibos.php","inicio",$RegistrosXPagina,false);	
                //EscribeBitacora(72, "comentario");			
            }
            else{
                Mensaje("No existen Recibos dados de alta en la Base de Datos !!!");    
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