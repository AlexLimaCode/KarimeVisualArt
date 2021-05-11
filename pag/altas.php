<?php

    include('./conexion.php');
    $query = "select * from tblObrasArte";
    $resultado = mysqli_query($conn,$query);
?>


<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trip trip</title>
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <!-- CDN Font awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
    />
    <!-- CSS Main -->
    <link rel="stylesheet" href="../css/main.css" />
    <script>
      function Muestra(){
        //RECIBO LOS VALORES COMO OBJECT
        if ((document.principal.titulo.value=="") || (document.principal.des.value=="") || (document.principal.precio.value=="") || (document.principal.fecha.value=="0000-00-00")) {
          alert("SE DEBEN LLENAR TODOS LOS CAMPOS");
          alert("El valor de titulo es: "+document.principal.titulo.value);
          alert("El valor de des es: "+document.principal.des.value);
          alert("El valor de precio es: "+document.principal.precio.value);
          alert("El valor de fecha es: "+document.principal.fecha.value);
        } else {
          alert("TODO ESTA CORRECTO");
        }
      }
    </script>
  </head>
  <body>
    
  

    <!-- USO LAS CLASES DE BOOTSTRAP -->
    <!-- FORMULARIO PARA QUE ACTUALICE, BORRE O DE DE ALTA OBRAS -->
    <div class="container text-center justify-content-center">
        <div class="row">
            <div class="col-lg-4">
                <h1 class="text-primary">Llene los datos de la Obra</h1>
                <form  method="post" enctype="multipart/form-data" id="FormularioAltas" name="principal">
                    <div class="form-group">
                        <label for="my-input">Titulo de la Obra</label>
                        <input id="my-input" class="form-control" type="text" name="titulo">
                        <br>
                        <br>
                        <label for="my-input">Descripcion de la Obra</label>
                        <input id="my-input" class="form-control" type="text" name="des">
                        <br>
                        <br>
                        <label for="my-input">Precio de la Obra</label>
                        <input id="my-input" class="form-control" type="text" name="precio">
                    </div>
                    
                    <!-- AGREGO UN SELECT PARA QUE ESCOGA SI ES DE LA 1 O 2 O 3 -->

                    <br>
                    <br>
                    SELECCIONA EL TIPO DE PINTURA QUE ES    
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="tipo">
                        <Option value="1" selected>pintura
                        <option value="2">grabado
                        <option value="3">ilustracion
                    </select>
                    <br>
                    <br>
                    <label for="my-input">Fecha de Creacion</label>
                    <input type="date" name="fecha">
                    <br>
                    <br>                    
                    <input type="button" value="Guardar" name="Guardar" class="btn btn-primary" onclick="Muestra()">
                </form>
            </div>
        </div>
    </div>

    
    

    <!-- Jquery -->
    <script src="../js/jquery-3.5.0.min.js"></script>
    <!-- Popper -->
    <script src="../js/popper.min.js"></script>
    <!-- JS Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- INSERTO EL JS DE MIS FUNCIONES, EL MAIN -->
    <script src="../js/main.js"></script>
  </body>
</html>