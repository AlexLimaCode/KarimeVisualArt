
  <!-- UNIVERSIDAD ANAHUAC   -->
  <!-- INGENIERIA EN SISTEMAS COMPUTACIONALES           -->
  <!-- Funciones en PHP                      -->
  <!-- Fecha de Elaboraci�n: ENERO 2021 -->
  <!-- Autor: ALEJANDRO LIMA MARTINEZ        -->
  <!-- Version 1.0                           -->
  <!-- Descripcion del Programa  :           -->
  <!-- Es el marco principal de trabajo, manda llamar al menu y despliega el usuario que accesa al sistema      --> 

<?php
session_start();
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
        <link rel="stylesheet" href="../css/admin.css" />
		<link rel="stylesheet" href="../css/estilos.css" type="text/css">
    <?php include("Funciones.php"); ?>
    
    <script>
        function abrir() {
            window.open('Final.php', '_blank', '')
        }

        ajustar = function(object) {
            var doc = object.contentDocument ? object.contentDocument
                    : object.contentWindow.document;
            object.height = getDocHeight(doc);
        }

        getDocHeight = function(doc) {
            doc = doc || document;
            var body = doc.body;
            var html = doc.documentElement;

            var height = Math.max(body.scrollHeight, body.offsetHeight,
                    html.clientHeight, html.scrollHeight, html.offsetHeight);
            return height;
        }
    </script>    


</head>
<?php 
    
if (!Permiso("menuPrincipal.php")) {    //funcion que verifica si el usuario tiene permiso al formulario.
    Mensaje("Ud. no tiene permisos para accesar al menuPrincipal, verifique con el Administrador del Sistema (menuPrincipal.php)");
    echo "<script language=\"javascript\">";
    echo "window.location='inicio.php'";
    echo "</script>";
} 
else {  // Significa que el usuario tiene permitido el acceso a este Formulario ?> 
    
    <body>
    <form name="principal" method="POST">
        
        <table> <!-- Hacemos una tabla con 2 columnas, donde desplegamos el menu y el usuario -->
             <?php 
                include('menu.php') // invoca al menu
            ?> 
            <tr>
                <td> &nbsp;</td>   <!-- en esta columna no ponemos nada, porque en la segunda se despliega el usuario -->
                    
            </tr>
        </table>
        <?php
                echo '<h1 class="admin">'.$_SESSION["nombreUsuario"].'</h1>';  // despliega el usuario que esta activo
        ?> 

        <table width="100%">  <!-- Hacemos otra tabla con una sola columna, donde deplegaremos los formularios  -->
            <tr>  
                <td valign="top">
                   <iframe onload="ajustar(this)" name="Contenido"  width="100%" height="800px" src="principio.php" scrolling="yes" frameborder="0" allowtransparency>   
                        Tu navegador no soporta iframes
                    </iframe>
                </td>
            </tr>
        </table>
        
    </form>
    </body>

<?php 
}  // esta llave cierra el ELSE, donde se valida si el usuario tiene acceso a este formulario
?>    
</html>