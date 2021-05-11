<?php

session_start();  // la variable session se debe declarar antes de la etiqueta html session_start();

 $_SESSION["SesionBD"] = "mibase";              //   Nombre de la base de datos
// $_SESSION["SesionIP"] = "187.141.2.122"; 
 $_SESSION["SesionIP"] = "localhost";           //   Ruta del servidor donde se encuentra la base de datos
 $_SESSION["SesionUS"] = "root";                //   Login del usuario de la Base de datos
 $_SESSION["SesionPS"] = "";                    //   Password del usuario de la Base de datos
 
 $_SESSION["CveUsuarioSistema"]="";             //   Usuario que ingresa
 $_SESSION["nombreUsuario"]="";                 //   Nombre del Usuario que ingresa


?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Arte Visual</title>
		<link rel="stylesheet" href="../css/style.css" type="text/css">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>Document</title>
		<!-- CSS Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<!-- Linkeo el css -->
		<link rel="stylesheet" href="../css/global.css" />
		<!-- CDN Font awesome -->
		<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
		/>
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
			function cancelar(){
				document.principal.Login.value=""
				document.principal.Passw.value=""
				document.principal.accion.value="Cancelar"
				document.principal.submit()
			}
			function enviar(){
				document.principal.accion.value="Aceptar"
				
          
				document.principal.submit()
			}
		
		</script>
	</head>

	<body class="bg">
		<table >
			<tr>
				<td>
					<table>
						<tr>
							<?php
								conectar();
								$result = mysqli_query($_SESSION["Conexion"],"select * from usuarios");
								if (mysqli_num_rows($result)<=0){
									Mensaje("No existen usuarios en la Base de Datos, verifique con el Administrador de Sistemas !!!");
								}
								else{
								   // no hacemos nada	
								}
								mysqli_free_result($result);
								Desconectar();
							?>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		<div id="divLogin" class="container centermenu">
            <form name="principal" method="POST" action="inicio.php" class="form-container">
				<input type="hidden" name="accion" value="Cancelar">
				<div class="mb-3">
					<label for="user" class="form-label">Usuario: </label><input name="Login" id="Login" type="text" class="form-control" onKeyPress="cambia('Passw','')" onFocus="selecciona('Login')"  maxlength="10">
				</div>
				<div class="mb-3">
					<label for="pass" class="form-label">Contrase&ntilde;a: </label><input name="Passw" id="Passw" type="password" class="form-control" onKeyPress="cambia('bntAceptar','Login')" onFocus="selecciona('Passw')"  maxlength="10">
				</div>
				<div style="width:100%; text-align:center;">
					<input type="button" id="login" name="bntAceptar" value="  Entrar  " class="btn btn-primary btn-block" style="background: url(img/bkgBoton.jpg);color:#000000;font-weight:bold;" onClick="enviar()">
					&nbsp;&nbsp;&nbsp;
					<input type="button" id="cancel" name="bntCancelar" value="  Cancelar  " class="btn btn-primary btn-block" style="background: url(img/bkgBoton.jpg);color:#000000;font-weight:bold;" onClick="cancelar()">
				</div>
			</form>
                
            <?php
				// ----------------------------------------
				//   aqui inicia el procedimiento en PHP
				//------------------------------------------
                
                if(isset($_POST["accion"])){   // validamos que la variable este definida, para que no truene la primera vez que entra

				    $accion = $_POST['accion'];   // es un campo de texto que nos indica la accion a realizar en el sistema
												
				    if ($accion=="Cancelar"){
					    // si cancelaron solo se recarga la pagina
				    }
				    if ($accion=="Aceptar"){
                        
                        // Recojo el valor de la clave principal del Formulario en cuestion
                                       
                        $Login = $_POST["Login"];
					    $Passw = $_POST["Passw"];
                        //echo "usuario='$Login' and contrasenia='$Passw'";

					    if ($Login==""){
						    Mensaje("Debe proporcionar el Login necesariamente !!!");
					    }
					    if ($Passw==""){
						    Mensaje("Debe proporcionar el Password necesariamente !!!");
					    }
					    else{
						    if (($Login!="") and ($Passw!="")){
							    conectar();
							    $result = mysqli_query($_SESSION["Conexion"], "select * from usuarios  where usuario='$Login' and contrasenia='$Passw'");
                                
                                if (mysqli_num_rows($result)<=0){
								    Mensaje("No existe el usuario en el sistema, verifique !!!");
							    }
							    else{
                                    $row=mysqli_fetch_array($result);
									//echo '<td class="Arial10">'.$row['acronimo'].', '.$row['Nombre'].'</td>';
									$_SESSION["CveUsuarioSistema"]=$row['IdUsuario']; 
									$_SESSION["nombreUsuario"]=$row['acronimo'].', '.$row['Nombre'];
									//$Err = EscribeBitacora(1,"Entrada al Sistema");
				      				echo "<script>window.open('menuPrincipal.php','_self','')</script>";
						    	}	
							    mysqli_free_result($result);
							    Desconectar();
                            }   
                        }	
					}	
				}

			?>
               
		</div>
		
		<script>
			document.principal.Login.focus();
		</script>
	<!-- Jquery -->
	<script src="../js/jquery-3.5.0.min.js"></script>
    <!-- Popper -->
    <script src="../js/popper.min.js"></script>
    <!-- JS Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
	</body>
</html>