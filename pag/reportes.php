<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTES</title>
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

</head>
<body>
	<br>
    <div class="container">
		<p class="fs-1">SELECCIONA EL TIPO DE REPORTE DE VENTAS REQUERIDO</p>
		<form name="input" action="reportespdf.php" method="post">
			<div class="form-check">
				<input class="form-check-input" type="radio" name="radio-stacked" id="dia" value="dia">
				<label class="form-check-label" for="flexRadioDefault1">
					DIA
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="radio-stacked" id="mes" value="mes" checked>
				<label class="form-check-label" for="flexRadioDefault2">
					MES
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="radio-stacked" id="ano" value="ano">
				<label class="form-check-label" for="flexRadioDefault1">
					AÑO
				</label>
			</div>
			<br>
			<label for="birthday">SELECCIONA LA FECHA:</label>
					<br>
					<input type="date" id="fecha" name="fecha" required>
					<br>
			<br>
			<input class="btn btn-primary btn-lg" type="submit" value="Genera PDF">
		</form>
	</div>
	

	<!-- Jquery -->
	<script src="../js/jquery-3.5.0.min.js"></script>
    <!-- Popper -->
    <script src="../js/popper.min.js"></script>
    <!-- JS Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>