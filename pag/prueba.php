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
		<link rel="stylesheet" href="../css/estilos.css" type="text/css">
		<?php include("Funciones.php"); ?>
    </head>
    
	    <body>
        <form name="principal" method="POST" action="estatusObras.php">
            <input type="hidden" name="accion" value="">        <!-- es la accion que hara el usuario al presionar un boton -->
            <input type="hidden" name="CveEstatus" value="">    <!-- es el estatus de la tabla tblestatus -->

            <table width="100%">
			<tr>
                <td width="50%">Nombre del Estatus de la Obra: </td>
                <td width="50%"><input type="text" name="nombre"></td>
            </tr>   
            </table>
          
            <div>
				<input type="button" value=" Actualizar" onClick="actualizar()">
                &nbsp;&nbsp;&nbsp;
                <input type="button" value=" Eliminar" onClick="eliminar()">
                &nbsp;&nbsp;&nbsp;
                <input type="button" value=" Consultar" onClick="consultar()">
				&nbsp;&nbsp;&nbsp;
				<input type="button" value=" Limpiar" onClick="limpiar()">
			</div>
            
        </form>
        </body>
</html>