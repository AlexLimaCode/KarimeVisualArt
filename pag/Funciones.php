
  <!-- UNIVERSIDAD ANAHUAC   -->
  <!-- INGENIERIA EN SISTEMAS COMPUTACIONALES           -->
  <!-- Funciones en PHP                      -->
  <!-- Fecha de Elaboraci�n: ENERO 2021 -->
  <!-- Autor: ALEJANDRO LIMA MARTINEZ        -->
  <!-- Version 1.0                           -->
  <!-- Descripcion del Programa  :           -->
  <!-- Aqui se encuentran todas las funciones en PHP que ocupo en el sistema      --> 

<?php

// Funcion para conectarse a una Base de Datos
function Conectar(){
  $_SESSION["Conexion"] = mysqli_connect($_SESSION["SesionIP"],$_SESSION["SesionUS"],$_SESSION["SesionPS"],$_SESSION["SesionBD"]); 
    
}

//  Funcion que cierra una conexion
function Desconectar(){
  $Conexion = $_SESSION["Conexion"];
  mysqli_close($Conexion);
}

// Funcion que calcula el iva predeterminadamente en el 16%, solo es diferente si el parametro es 
// especificado de otra manera
function CalculaIva($cantidad, $iva=16){
	$resultado = $cantidad * ($iva/100);
	return $resultado;
}

function CreaDirectorio($NomDirectorio){
	$VectorDirectorio = preg_split("[/]",$NomDirectorio);  //	construimos un arreglo con las carpetas
	$ruta = ".";
	foreach ($VectorDirectorio as $Carpeta){
		if($Carpeta!="." && trim($Carpeta)!=""){
			$ruta = $ruta."/".$Carpeta;
			if (ExisteArchivo($ruta)){
				//  ya existe la carpeta, por lo tanto ya no la hacemos
			}
			else{
				mkdir($ruta, 0774);
			}
			//Mensaje("ruta: $ruta");
  		}
	}	
}


function CambFecHor_a_Normal($fecha){ 
    preg_match("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2})", $fecha, $mifecha); 
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]." ".$mifecha[4].":".$mifecha[5]; 
    return $lafecha; 
} 

//Convierte fecha de mysql a normal 
function cambiaf_a_normal($fecha){ 
    preg_match("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); 
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
    return $lafecha; 
} 

//Convierte fecha de normal a mysql 
function cambiaf_a_mysql($fecha){ 
    preg_match( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha); 
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 
    return $lafecha; 
} 


// Funcion que crea una tabla con un conjunto de registros
function CreaTabla($TituloMalla,$result, $Titulos, $ini, $Link, $Parametro, $RegXPag, $ConEliminacion){
  
	// Obtenemos el nombre del primer campo de la tabla que vamos a desplegar	
	$info_campo = mysqli_fetch_fields($result);
	$i=0;
	foreach ($info_campo as $valor) {
		if ($i==0){
			$info = $valor->name;	
		}
		$i=$i+1;
	}
    $Columnas = $i;   
	
	if ($result && mysqli_num_rows($result)>0){
		if ($ConEliminacion==true){
			$Extiende = $Columnas + 1;
		}	
		else{
			$Extiende = $Columnas;
		}	
  		//  desplegamos el titulo de la malla
  		echo "<table class = 'Arial11 table' width='100%' border='1' cellpadding='2' align='center' style='border-collapse: collapse' bgcolor='#E2EBF4'>";
  		echo "<tr><td class='table-primary' colspan='$Extiende' align='center'><b>".$TituloMalla."</b></td></tr>";

  		//  desplegamos todas las paginas de la malla
		echo "<tr><td colspan='$Extiende' align='left'>";
		$x = (mysqli_num_rows($result) / $RegXPag);
		$Residuo = (mysqli_num_rows($result) % $RegXPag);
		$ParteEntera = (int)$x;
		if ($Residuo == 0) $ParteEntera = $ParteEntera - 1 ;
		$i = 0;
		echo "<b> Numero de Registros : ".mysqli_num_rows($result).">&nbsp;&nbsp;&nbsp;&nbsp;</b>Paginas :&nbsp;";
		while (($i) <= $ParteEntera){
			
      		echo "<a class='liga_verde' href=".$Link."?pag=".(($i * $RegXPag)+$RegXPag)."&".$Parametro.">".(($i * $RegXPag)+1)."-".(($i * $RegXPag)+$RegXPag)."</a>&nbsp;&nbsp;";
	  		$i++;
		} 
		echo "</td></tr>";
	
		// desplegamos los nombres de los encabezados de las columnas
    	echo "<tr bgcolor='9EBCDA'>";
    	for ($i=0;$i<$Columnas;$i++){
	  		if ($i==0)
	    		echo "<td width='5%'><b>".$Titulos[$i]."</b></td>";
	  		else
        		echo "<td><b>".$Titulos[$i]."</b></td>";
    	}	 
		if ($ConEliminacion==true){
			echo "<td><button value='GuardarImp' name='GuardarImp' onClick='clickEliminaRegistros()'>";
			echo "<img src='../images/borrar.gif' border='0'></button></td>";
		}	
		echo "</tr>";
	
		// desplegamos los registros 
		$Inicio = $ini + 1 ;
		$Final = $ini + $RegXPag;
		$Reg = 1;
		$non = "1";
		$Renglon = 1;

		while ($row=mysqli_fetch_array($result)){
	  		if (($Reg >= $Inicio) && ($Reg <= $Final)){
				//CONTROLAMOS LOS COLORES DE REGISTRO PARA LA TABLA
		  		if ($non=="1"){
		    		echo '<tr  bgcolor="#CBDBEB" onMouseOver="uno(this,\'cccccc\');" onMouseOut="dos(this,\'CBDBEB\');">';
					$non = "0";
				}
				else{
					echo '<tr  onMouseOver="uno(this,\'cccccc\');" onMouseOut="dos(this,\'E2EBF4\');">';
					$non = "1";
				}	
	    		for ($i=0;$i<$Columnas;$i++){
	      			if ($i==0)
		    			echo "<td width='5%'>".$Reg."</td>";
		  			elseif ($i==1){
		     	     	if (EsFecha($row[$i])){//LO MANDO A LA FUNCION FECHA
				          	if(EsFecha_hora($row[$i])){	
					           echo "<td><a class='liga_verde' href=".$Link."?".$info."=".$row[$i-1]."&".$Parametro.">".CambFecHor_a_Normal($row[$i])."</a></td>";
					        }
					        else{
					               echo "<td><a class='liga_verde' href=".$Link."?".$info."=".$row[$i-1]."&".$Parametro.">".cambiaf_a_normal($row[$i])."</a></td>";
						    }  
				        }	
					    else{
							
							echo "<td><a class='liga_verde' href=".$Link."?".$info."=".$row[$i-1]."&pag=".($Inicio+9).">".$row[$i]."</a></td>";
						}
				   	}
		  			else{ 
		    			if (EsFecha($row[$i])){
				     		if(EsFecha_hora($row[$i])){
					     		echo "<td>".CambFecHor_a_Normal($row[$i])."</td>"; 
					   		}
					  		else{
					      		echo "<td>".cambiaf_a_normal($row[$i])."</td>";
							}  
				   		}	
			    		elseif($row[$i]=="0/")
				      		echo "<td> </td>";
		    			else
          					echo "<td>".$row[$i]."</td>";
		  			}	
				}	
				if ($ConEliminacion==true){
					echo "<td width='5%'><input type='checkbox' name='Casillas".$Renglon."' value='".$row[0]."'></td>";
				}	
				echo "</tr>";
				$Renglon++;
	  		}	
			if ($Renglon>$RegXPag){break;}
	  		$Reg++;
  		}
		echo "</table>";
  	} 
}

//		regresa el dia de la semana 0-domingo, 6-sabado
function DameDia($Fecha){
	$mes = substr($Fecha,5,2);
	$dia = substr($Fecha,8,2);
	$ani = substr($Fecha,0,4);
	$Fecha = getdate(mktime(0,0,0,$mes,$dia,$ani));
	return $Fecha['wday']; 
}



function ExisteArchivo($NomArchivo){
	if (file_exists($NomArchivo)){
   //Mensaje("NomArchivo: $NomArchivo - Existe");
	   return true;
   } 
   else{
	   //Mensaje("NomArchivo: $NomArchivo - No Existe");
	   return false;
   }
}

// Funcion que verifica que el campo enviado es una fecha

function EsFecha($Campo){
    if (substr($Campo,4,5)=="-" && substr($Campo,7,8)=="-" && substr($Campo,13,14)==":" && substr($Campo,16,17)==":" )  // este se ocupar� cuando la fecha tambien almacene la hora
	   {
	     return true;
	   }
	elseif (substr($Campo,4,5)=="-" && substr($Campo,7,8)=="-")
         return true;
}
function EsFecha_hora($Campo){
    if ($Campo[4] == "-" && $Campo[7] == "-" && $Campo[13] == ":" && $Campo[16] == ":")  // este se ocupar� cuando la fecha tambien almacene la hora
		 return true;
	 
}

//Funcion que regresa el nombre del dia y el mes en formato largo
function FecReg($fecha, $fecha1){
	$arrDia = array("","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
	$arrMes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$anio = substr($fecha,0,4);
	$str = substr($fecha,5,2);   //Guardo el mes pero es string
	$num = (int)$str; //Convierto el mes en entero
	$dia = substr($fecha,8,2);
	$hora = substr($fecha,11,5);
	$nomDia = $arrDia[date("N",strtotime($fecha))];
	$mes = $arrMes[$num];
	$hora1 = substr($fecha1,11,5);
	
	return $nomDia." ".$dia."/".$mes."/".$anio." ".$hora." - ".$hora1;
}



function FechaLarga($fecha){

	$anio = substr($fecha,0,4);
	if(substr($fecha,5,2)=="01"){$mes ="Enero";}
	if(substr($fecha,5,2)=="02"){$mes ="Febrero";}
	if(substr($fecha,5,2)=="03"){$mes ="Marzo";}
	if(substr($fecha,5,2)=="04"){$mes ="Abril";}
	if(substr($fecha,5,2)=="05"){$mes ="Mayo";}
	if(substr($fecha,5,2)=="06"){$mes ="Junio";}
	if(substr($fecha,5,2)=="07"){$mes ="Julio";}
	if(substr($fecha,5,2)=="08"){$mes ="Agosto";}
	if(substr($fecha,5,2)=="09"){$mes ="Septiembre";}
	if(substr($fecha,5,2)=="10"){$mes ="Octubre";}
	if(substr($fecha,5,2)=="11"){$mes ="Noviembre";}
	if(substr($fecha,5,2)=="12"){$mes ="Diciembre";}	
	$dia = substr($fecha,8,2);
	$hora = substr($fecha,11,5);

	return $dia." de ".$mes." de ".$anio." a las: ".$hora." hrs.";
}


function Permiso($Archivo){
  Conectar();
  $sql = "select * from tblpermisos P, tblformularios F
                         where P.idFormulario = F.idFormulario and
						 P.idUsuario = ".$_SESSION["CveUsuarioSistema"]." and
						 F.Archivo = '$Archivo'";
  //echo "query: ".$sql;
  $result = mysqli_query($_SESSION["Conexion"],$sql);
  $row = mysqli_fetch_array($result);
  if (mysqli_num_rows($result)>0){
	$_SESSION["PermisoActualizar"] = $row['tipoPermiso'];
  }					 
  mysqli_free_result($result);
  Desconectar();
  if ($row) return true;
  else return false;
}



// Funcion que llena un cuadro combinado con el query, el valor selected que debe de tener y el valor que cachara en post o get
function LlenaCombo($Sql,$descripcion,$valor){
	Conectar();
	$result = mysqli_query($_SESSION["Conexion"],$Sql);
	if (mysqli_num_rows($result)>0){
		$i=0;
		$j=0;
		echo"<select class='form-select form-select-lg mb-3' aria-label='.form-select-lg example' name='$valor'>";
	  	while ($row=mysqli_fetch_row($result)){
			if($row[$i]==$descripcion){
				echo "<Option selected value=".($j+1).">$row[$i]";
			}else{
				echo "<Option value=".($j+1).">$row[$i]";
			}
			$j++;	
		}
		
	}
		echo"</select>";
		mysqli_free_result($result);
			
}
  

// funcion para deplegar mensajes
function Mensaje($str){
	$language = "language=\"javascript\"";
	echo "<script $language>\n";
	echo " alert('$str');\n";
	echo "</script>\n";
}


function NivelPermisos($archivo){ //Cambia el nivel de permisos de un archivo
 if(file_exists($archivo)){ 
  return chmod($archivo,0664);
 }else{
  return false;
 } 
}



//   Funcion para obtener la fecha del servidor, ojo, tambien nos trae la hora
function ObtenerAni(){
	$result = mysqli_query( $_SESSION["Conexion"],"SELECT NOW() AS FECHA");
	if (mysqli_num_rows($result)<=0){
		Mensaje("Error en obtener la fecha del servidor");
	}																				 
	else{
		$row = mysqli_fetch_array($result);
	  return substr($row["FECHA"],2,2);
	}
}


function RestarHoras($horaini,$horafin)
{
    $horai=substr($horaini,0,2);
    $mini=substr($horaini,3,2);
  
    $horaf=substr($horafin,0,2);
    $minf=substr($horafin,3,2);
  
    $ini=((($horai*60)*60)+($mini*60));
    $fin=((($horaf*60)*60)+($minf*60));
 
    $dif=$fin-$ini;
 
    $difh=floor($dif/3600);
    $difm=floor(($dif-($difh*3600))/60);
		return ($difh * 60) + $difm;
    //return date("H:i",mktime($difh,$difm));
}


//funcion que agrega un determinado numero de renglones en blanco, de acuerdo al parametro numero
function renglones($numero){ 
	for ($i=0;$i<$numero;$i++){ 
		echo "<br>"; 
	} 
}


// funcion que nos suma dias a una fecha
function SumaDias($FechaPosibleAud,$NumDias){
	$mes = substr($FechaPosibleAud,5,2);
	$dia = substr($FechaPosibleAud,8,2);
	$ani = substr($FechaPosibleAud,0,4);
	$Fecha = date("d-m-y H:i",mktime(0,0,0,$mes,$dia + $NumDias,$ani));
	return "20".substr($Fecha,6,2)."-".substr($Fecha,3,2)."-".substr($Fecha,0,2);
}



//  Funcion que coloca los titulos de los formularios
function Titulo($Leyenda){
  echo '<div class="contenedor">';
  echo '<div class="sombra">';
  echo '<u>'.$Leyenda.'</u>';
  echo '</div>';
  echo '<div class="cont">';
  echo '<u>'.$Leyenda.'</u>';
  echo '</div>';
  echo '</div>';
}


/* 							FUNCIONES ALEJANDRO LIMA
------------------------------------------------------------------*/
// Funcion que crea una tabla con imagenes 
function TablaImagenes($TituloMalla,$result, $Titulos, $ini, $Link, $Parametro, $RegXPag, $ConEliminacion){
	$info_campo = mysqli_fetch_fields($result);
	$i=0;
	foreach ($info_campo as $valor) {
		if ($i==0){
			$info = $valor->name;	
		}
		$i=$i+1;
	}
    $Columnas = $i;   
	
	if ($result && mysqli_num_rows($result)>0){
		if ($ConEliminacion==true){
			$Extiende = $Columnas + 1;
		}	
		else{
			$Extiende = $Columnas;
		}	
  		//  desplegamos el titulo de la malla
  		echo "<table class = 'Arial11 table' width='100%' border='1' cellpadding='2' align='center' style='border-collapse: collapse' bgcolor='#E2EBF4'>";
  		echo "<tr><td class='table-primary' colspan='$Extiende' align='center'><b>".$TituloMalla."</b></td></tr>";

  		//  desplegamos todas las paginas de la malla
		echo "<tr><td colspan='$Extiende' align='left'>";
		$x = (mysqli_num_rows($result) / $RegXPag);
		$Residuo = (mysqli_num_rows($result) % $RegXPag);
		$ParteEntera = (int)$x;
		if ($Residuo == 0) $ParteEntera = $ParteEntera - 1 ;
		$i = 0;
		echo "<b> Numero de Registros : ".mysqli_num_rows($result).">&nbsp;&nbsp;&nbsp;&nbsp;</b>Paginas :&nbsp;";
		while (($i) <= $ParteEntera){
			
      		echo "<a class='liga_verde' href=".$Link."?pag=".(($i * $RegXPag)+$RegXPag)."&".$Parametro.">".(($i * $RegXPag)+1)."-".(($i * $RegXPag)+$RegXPag)."</a>&nbsp;&nbsp;";
	  		$i++;
		} 
		echo "</td></tr>";
	
		// desplegamos los nombres de los encabezados de las columnas
    	echo "<tr bgcolor='9EBCDA'>";
    	for ($i=0;$i<$Columnas;$i++){
	  		if ($i==0)
	    		echo "<td width='5%'><b>".$Titulos[$i]."</b></td>";
	  		else
        		echo "<td><b>".$Titulos[$i]."</b></td>";
    	}	 
		if ($ConEliminacion==true){
			echo "<td><button value='GuardarImp' name='GuardarImp' onClick='clickEliminaRegistros()'>";
			echo "<img src='img/borrar.gif' border='0'></button></td>";
		}	
		echo "</tr>";
	
		// desplegamos los registros 
		$Inicio = $ini + 1 ;
		$Final = $ini + $RegXPag;
		$Reg = 1;
		$non = "1";
		$Renglon = 1;

		while ($row=mysqli_fetch_array($result)){
	  		if (($Reg >= $Inicio) && ($Reg <= $Final)){
				//CONTROLAMOS LOS COLORES DE REGISTRO PARA LA TABLA
		  		if ($non=="1"){
		    		echo '<tr  bgcolor="#CBDBEB" onMouseOver="uno(this,\'cccccc\');" onMouseOut="dos(this,\'CBDBEB\');">';
					$non = "0";
				}
				else{
					echo '<tr  onMouseOver="uno(this,\'cccccc\');" onMouseOut="dos(this,\'E2EBF4\');">';
					$non = "1";
				}	
	    		for ($i=0;$i<$Columnas;$i++){
	      			if ($i==0)
		    			echo "<td width='5%'>".$Reg."</td>";
		  			elseif ($i==1){
		     	     	if (EsFecha($row[$i])){//LO MANDO A LA FUNCION FECHA
				          	if(EsFecha_hora($row[$i])){	
					           echo "<td><a class='liga_verde' href=".$Link."?".$info."=".$row[$i-1]."&".$Parametro.">".CambFecHor_a_Normal($row[$i])."</a></td>";
					        }
					        else{
					               echo "<td><a class='liga_verde' href=".$Link."?".$info."=".$row[$i-1]."&".$Parametro.">".cambiaf_a_normal($row[$i])."</a></td>";
						    }  
				        }	
					    else{
							
							echo "<td><a class='liga_verde' href=".$Link."?".$info."=".$row[$i-1]."&pag=".($Inicio+9).">".$row[$i]."</a></td>";
						}
				   	}
		  			else{ 
		    			if (EsFecha($row[$i])){
				     		if(EsFecha_hora($row[$i])){
					     		echo "<td>".CambFecHor_a_Normal($row[$i])."</td>"; 
					   		}
					  		else{
					      		echo "<td>".cambiaf_a_normal($row[$i])."</td>";
							}  
				   		}	
			    		elseif($row[$i]=="0/")
				      		echo "<td> </td>";
		    			else
          					echo "<td><img src='../images/obras/".$row[$i]."' border='0' width=300; height=300; align=center;></td>";
		  			}	
				}	
				if ($ConEliminacion==true){
					echo "<td width='5%'><input type='checkbox' name='Casillas".$Renglon."' value='".$row[0]."'></td>";
				}	
				echo "</tr>";
				$Renglon++;
	  		}	
			if ($Renglon>$RegXPag){break;}
	  		$Reg++;
  		}
		echo "</table>";
  	} 
}



function LoadObras($NomObra,$DesObra,$FechaObra,$PrecioObra,$NomTipo,$NomEstatus){
	/*$result2 = mysqli_query($_SESSION["Conexion"],"insert into tblobrasarte(NomObra) values('$nombre')");*/
	//Mensaje($FechaObra);

	if ($NomObra=="" || $DesObra=="" || $FechaObra=="" || $PrecioObra=="" || $NomTipo=="" || $NomEstatus=="") {
		Mensaje("NECESITA LLENAR TODOS LOS CAMPOS CON DATOS VALIDOS");
	}else{
		$result=mysqli_query($_SESSION["Conexion"], "insert into tblobrasarte (NomObra,DesObra,FechaObra,PrecioObra,CveTipo,CveEstatus) values ('$NomObra','$DesObra','$FechaObra','$PrecioObra',$NomTipo,$NomEstatus)");
		Mensaje("ALTA EXITOSA");
	}
}

function LoadRecibos($IdRecibo,$nombre,$DesEstatus,$FechaEmision,$MontoTotal,$FechaPago,$FechaValidacion,$FechaCancelacion,$name,$Paterno,$Materno,$Correo,$Telefono){
	/*$result2 = mysqli_query($_SESSION["Conexion"],"insert into tblobrasarte(NomObra) values('$nombre')");*/
	//Mensaje($FechaObra);

	if ($NomObra=="" || $DesObra=="" || $FechaObra=="" || $PrecioObra=="" || $NomTipo=="" || $NomEstatus=="") {
		Mensaje("NECESITA LLENAR TODOS LOS CAMPOS CON DATOS VALIDOS");
	}else{
		$result=mysqli_query($_SESSION["Conexion"], "insert into tblobrasarte (NomObra,DesObra,FechaObra,PrecioObra,CveTipo,CveEstatus) values ('$NomObra','$DesObra','$FechaObra','$PrecioObra',$NomTipo,$NomEstatus)");
		Mensaje("ALTA EXITOSA");
	}
}

//VALIDO A DONDE HACER EL UPDATE
function UpdateObras($IdObra,$NomObra,$DesObra,$FechaObra,$PrecioObra,$NomTipo,$NomEstatus){
	
	//Mensaje($IdObra.$NomObra.$DesObra.$FechaObra.$PrecioObra.$NomTipo.$NomEstatus);

	if ($DesObra=="" || $FechaObra=="0000-00-00" || $PrecioObra=="" || $NomTipo=="" || $NomEstatus=="") {
		Mensaje("NECESITA LLENAR TODOS LOS CAMPOS CON DATOS VALIDOS");
	}else{
		
		$result=mysqli_query($_SESSION["Conexion"], "update tblobrasarte set NomObra='$NomObra', DesObra='$DesObra', FechaObra='$FechaObra', PrecioObra='$PrecioObra', CveTipo='$NomTipo', CveEstatus='$NomEstatus' where IdObra='$IdObra'");
		Mensaje("MODIFICACION EXITOSA");
	}
}

function UpdateRecibos($IdRecibo,$nombre,$DesEstatus,$FechaEmision,$MontoTotal,$FechaPago,$FechaValidacion,$FechaCancelacion,$name,$Paterno,$Materno,$Correo,$Telefono){
	Mensaje("AVISO!! EL NOMBRE NO SE MODIFICARA YA QUE ES UNICO");
	//Mensaje($IdObra.$NomObra.$DesObra.$FechaObra.$PrecioObra.$NomTipo.$NomEstatus);

	if ($DesEstatus=="" || $FechaEmision=="0000-00-00" || $MontoTotal=="" || $name=="" || $Paterno=="" || $Materno=="" || $Correo=="" || $Telefono=="") {
		Mensaje("NECESITA LLENAR TODOS LOS CAMPOS CON DATOS VALIDOS");
		Mensaje("LA FECHA DE VALIDACION Y/O CANCELACION SI PUEDEN IR VACIAS, SOLO SI NO SE HAN CORRESPONDIDO");
	}else{
		$result=mysqli_query($_SESSION["Conexion"], "update tblrecibos set IdEstatus='$DesEstatus', FechaEmision='$FechaEmision', FechaPago='$FechaPago', FechaValidacion='$FechaValidacion', FechaCancelacion='$FechaCancelacion', MontoTotal='$MontoTotal', Nombre='$name', Paterno='$Paterno', Materno='$Materno', Correo='$Correo', Telefono='$Telefono' where IdRecibo='$nombre'");
		Mensaje("MODIFICACION EXITOSA");
	}
}

function CreaTablaRecibos($TituloMalla,$result, $Titulos, $ini, $Link, $Parametro, $RegXPag, $ConEliminacion){
  
	// Obtenemos el nombre del primer campo de la tabla que vamos a desplegar	
	$info_campo = mysqli_fetch_fields($result);
	$i=0;
	foreach ($info_campo as $valor) {
		if ($i==0){
			$info = $valor->name;	
		}
		$i=$i+1;
	}
    $Columnas = $i;   
	
	if ($result && mysqli_num_rows($result)>0){
		if ($ConEliminacion==true){
			$Extiende = $Columnas + 1;
		}	
		else{
			$Extiende = $Columnas;
		}	
  		//  desplegamos el titulo de la malla
  		echo "<table class = 'Arial11 table' width='100%' border='1' cellpadding='2' align='center' style='border-collapse: collapse' bgcolor='#E2EBF4'>";
  		echo "<tr><td class='table-primary' colspan='$Extiende' align='center'><b>".$TituloMalla."</b></td></tr>";

  		//  desplegamos todas las paginas de la malla
		echo "<tr><td colspan='$Extiende' align='left'>";
		$x = (mysqli_num_rows($result) / $RegXPag);
		$Residuo = (mysqli_num_rows($result) % $RegXPag);
		$ParteEntera = (int)$x;
		if ($Residuo == 0) $ParteEntera = $ParteEntera - 1 ;
		$i = 0;
		echo "<b> Numero de Registros : ".mysqli_num_rows($result).">&nbsp;&nbsp;&nbsp;&nbsp;</b>Paginas :&nbsp;";
		while (($i) <= $ParteEntera){
			
      		echo "<a class='liga_verde' href=".$Link."?pag=".(($i * $RegXPag)+$RegXPag)."&".$Parametro.">".(($i * $RegXPag)+1)."-".(($i * $RegXPag)+$RegXPag)."</a>&nbsp;&nbsp;";
	  		$i++;
		} 
		echo "</td></tr>";
	
		// desplegamos los nombres de los encabezados de las columnas
    	echo "<tr bgcolor='9EBCDA'>";
    	for ($i=0;$i<$Columnas;$i++){
	  		if ($i==0)
	    		echo "<td width='5%'><b>".$Titulos[$i]."</b></td>";
	  		else
        		echo "<td><b>".$Titulos[$i]."</b></td>";
    	}	 
		if ($ConEliminacion==true){
			echo "<td><button value='GuardarImp' name='GuardarImp' onClick='clickEliminaRegistros()'>";
			echo "<img src='img/borrar.gif' border='0'></button></td>";
		}	
		echo "</tr>";
	
		// desplegamos los registros 
		$Inicio = $ini + 1 ;
		$Final = $ini + $RegXPag;
		$Reg = 1;
		$non = "1";
		$Renglon = 1;

		while ($row=mysqli_fetch_array($result)){
	  		if (($Reg >= $Inicio) && ($Reg <= $Final)){
				//CONTROLAMOS LOS COLORES DE REGISTRO PARA LA TABLA
		  		if ($non=="1"){
		    		echo '<tr  bgcolor="#CBDBEB" onMouseOver="uno(this,\'cccccc\');" onMouseOut="dos(this,\'CBDBEB\');">';
					$non = "0";
				}
				else{
					echo '<tr  onMouseOver="uno(this,\'cccccc\');" onMouseOut="dos(this,\'E2EBF4\');">';
					$non = "1";
				}	
	    		for ($i=0;$i<$Columnas;$i++){
	      			if ($i==0)
		    			echo "<td width='5%'>".$Reg."</td>";
		  			elseif ($i==1){
		     	     	if (EsFecha($row[$i])){//LO MANDO A LA FUNCION FECHA
				          	if(EsFecha_hora($row[$i])){	
					           echo "<td><a class='liga_verde' href=".$Link."?".$info."=".$row[$i-1]."&".$Parametro.">".CambFecHor_a_Normal($row[$i])."</a></td>";
					        }
					        else{
					               echo "<td><a class='liga_verde' href=".$Link."?".$info."=".$row[$i-1]."&".$Parametro.">".cambiaf_a_normal($row[$i])."</a></td>";
						    }  
				        }	
					    else{
							
							echo "<td><a class='liga_verde' href=".$Link."?".$info."=".$row[$i-1]."&pag=".($Inicio+9)." onclick='CreateWindow(".$row[$i].")'>".$row[$i]."</a></td>";
						}
				   	}
		  			else{ 
		    			if (EsFecha($row[$i])){
				     		if(EsFecha_hora($row[$i])){
					     		echo "<td>".CambFecHor_a_Normal($row[$i])."</td>"; 
					   		}
					  		else{
					      		echo "<td>".cambiaf_a_normal($row[$i])."</td>";
							}  
				   		}	
			    		elseif($row[$i]=="0/")
				      		echo "<td> </td>";
		    			else
          					echo "<td>".$row[$i]."</td>";
		  			}	
				}	
				if ($ConEliminacion==true){
					echo "<td width='5%'><input type='checkbox' name='Casillas".$Renglon."' value='".$row[0]."'></td>";
				}	
				echo "</tr>";
				$Renglon++;
	  		}	
			if ($Renglon>$RegXPag){break;}
	  		$Reg++;
  		}
		echo "</table>";
  	} 
}


?>
