<?php
	include ("ConexionBD.php");
	
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
?>
<HTML>
<HEAD>
<TITLE>Dirección de Contraloria Interna del Poder Judicial del Estado de México</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<STYLE TYPE="text/css">
body {
	overflow:hidden;
}
</STYLE>
<SCRIPT LANGUAGE="JavaScript" SRC="JS/FuncionesPg.js"></SCRIPT>
<LINK REL="stylesheet" HREF="estilos.css" TYPE="text/css">
<SCRIPT LANGUAGE="javascript">
<!--   
history.go(1);

function Inicia(Opc){
	if(Opc=="1"){
		parent.document.getElementById('MeCo').cols='0,*';
		document.frmDatUsu.txtUsuario.focus();
	} else{
		parent.document.getElementById('MeCo').cols='150,*';
	}
}

function Acceso(opc,idreg){
   var TipoReg = opc;
	var idRegistro = idreg;
	var txtUsuario = document.frmDatUsu.nickname;
	var txtPassword = document.frmDatUsu.password;
	
	if(txtUsuario.value.length == 0){
	   alert("Error: Debes proporcionar un nombre de usuario.");
		txtUsuario.focus();
		return false;
	}
	if(txtPassword.value.length == 0){
	   alert("Error: Debes proporcionar una contraseña.");
		txtPassword.focus();
		return false;
	}
	document.frmDatUsu.target="";//VerDat
	document.frmDatUsu.action="VerAcceso.php";
	document.frmDatUsu.submit();
}

function RegresoPop(Datos){
	//alert(Datos.Opcion);
	if(Datos.Opcion == "OK"){
		document.frmReenvio.CveJuzgado.value=Datos.Juzgado;
		document.frmReenvio.Usr.value=Datos.Usr;
		Inicia('2');
		Reenviar(Datos.Pagina,Datos.Menu);
	} else{
		alert(Datos.MsgError);
	}
}

function Enter(Caja,Sig,e){
	var key;
	if(window.event)
		key = window.event.keyCode;     //IE
	else
		key = e.which;     //firefox
	if(key == 13){
		if(Caja.value.length > 0){
			if(Sig == "Validar"){
				Acceso();
			} else{
				Sig.focus();
			}
		} else{
			Caja.focus();
		}
	}
}

function Reenviar(Pag,Menu){
	document.frmReenvio.Menu.value = Menu;
	document.frmReenvio.target = "Menu";
	document.frmReenvio.action = Menu;
	document.frmReenvio.submit();
	
	document.frmReenvio.Pagina.value = Pag;
	document.frmReenvio.target = "Contenido";
	document.frmReenvio.action = Pag;
	document.frmReenvio.submit();
	
	/*document.frmReenvio.Pagina.value = Pag;
	document.frmReenvio.Menu.value = Menu;
	document.frmReenvio.action = "index.php";
	document.frmReenvio.submit();*/
}

/*function Inicia(){
	parent.document.getElementById('MeCo').cols='150,*';
}*/
//-->
</SCRIPT>
<?php
$Meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
$iDia=date("j");
$iMes=intval(date("m"));
$iAnio=date("Y");

$primero_del_mes = mktime (0,0,0, $iMes, 1, $iAnio);
$date_info = getdate($primero_del_mes);
$dia_1=$date_info['wday']; //Domingo=0, Lunes=1, ...

if($dia_1<=1)
   $iDiaLimite=6-$dia_1;
else
   $iDiaLimite=7;
?>
</HEAD>

<BODY LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" BGCOLOR="EFF0E3" onLoad="">
<TABLE WIDTH="100%" HEIGHT="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
	<TR>
	  <TD HEIGHT="79">
	  
			<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" BGCOLOR="#FFFFFF">
				<TR>
					<TD WIDTH="160" BACKGROUND="Imagenes/FondoBarraHor.gif" ALIGN="left" nowrap>
						<OBJECT CLASSID="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" CODEBASE="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" WIDTH="160" HEIGHT="66">
						<PARAM NAME="movie" VALUE="Imagenes/banner.swf">
						<PARAM NAME="quality" VALUE="high">
						<EMBED SRC="Imagenes/banner.swf" QUALITY="high" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer" TYPE="application/x-shockwave-flash" WIDTH="160" HEIGHT="66"></EMBED>
						</OBJECT>
					</TD>
					<TD HEIGHT="66" BACKGROUND="Imagenes/FondoBarraHor.gif" nowrap><IMG NAME="Titulo" SRC="Imagenes/Titulo.gif" WIDTH="415" HEIGHT="66" BORDER="0" ALT=""></TD><!-- width="571"-->
					<TD WIDTH="69" HEIGHT="66" nowrap><!--a href="Inicio.htm" target="Contenido"--><IMG NAME="Logo" SRC="Imagenes/Logo.gif" WIDTH="69" HEIGHT="66" BORDER="0" ALT=""><!--/a--></TD>
				</TR>
				<TR>
					<TD COLSPAN="3" HEIGHT="13" BGCOLOR="#DEDFC6" ALIGN="right" CLASS="Arial10">"2007, A&Ntilde;O DE LA CORREGIDORA JOSEFA ORTIZ DE DOM&Iacute;NGUEZ "</TD>
				</TR>
			</TABLE>

		</TD>
	</TR>
	<TR>
		<TD>

			<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" WIDTH="100%" HEIGHT="100%">
			  <TR>
				 <TD HEIGHT="60" VALIGN="middle" COLSPAN="2" ALIGN="center"><?php echo Titulo("Sistema de Contraloria Interna"); ?><!--img src="Imagenes/titInicio.gif"--></TD>
			  </TR>
			  <TR> 
				<TD ALIGN="center" VALIGN="middle"> 
				  <FORM NAME="frmDatUsu" METHOD="post" ACTION="">
					  <INPUT TYPE="hidden" NAME="Datos" VALUE="Ini">
					  <INPUT TYPE="hidden" NAME="CveJuzgado" VALUE="">
					  <INPUT TYPE="hidden" NAME="Usr" VALUE="">
					<TABLE WIDTH="527" HEIGHT="154" BGCOLOR="#EEEEDD" STYLE="border:.5pt solid #CCCCCC">
					  <!--tr>
						<td colspan="2" align="right" class="Arial14" style="border-bottom:.5pt solid #CCCCCC"><span style="color:#FF0000 ">Fecha limite: <?php echo "$iDiaLimite de $Meses[$iMes] del $iAnio"; ?></span></td>
					  </tr-->
					  <TR>
						<TD COLSPAN="2" CLASS="Arial18" STYLE="border-bottom:.5pt solid #CCCCCC">Acceso</TD>
					  </TR>
						 <TR>
						<TD WIDTH="192" ALIGN="right" CLASS="Arial11Bld" STYLE="border-bottom:.5pt solid #CCCCCC">Usuario:&nbsp;&nbsp;&nbsp;</TD>
						<TD WIDTH="323" STYLE="border-bottom:.5pt solid #CCCCCC"><INPUT NAME="nickname" TYPE="text" ID="txtUsuario" CLASS="frmcaja"  onFocus="foco(this);" onBlur="no_foco(this);" onKeyPress="Enter(this,document.frmDatUsu.password,event)"></TD>
					  </TR>
					  <TR>
						<TD CLASS="Arial11Bld" ALIGN="right" STYLE="border-bottom:.5pt solid #CCCCCC">Contrase&ntilde;a:&nbsp;&nbsp;&nbsp;</TD>
						<TD STYLE="border-bottom:.5pt solid #CCCCCC"><INPUT NAME="password" TYPE="password" ID="Password" CLASS="frmcaja"  onFocus="foco(this);" onBlur="no_foco(this);" onKeyPress="Enter(this,'Validar',event)"></TD>
					  </TR>
					  <TR>
						<TD COLSPAN="2" HEIGHT="50" ALIGN="center"><INPUT NAME="Button" TYPE="button" CLASS="frmboton" VALUE="   ACEPTAR   " onClick="Acceso();"></TD>
					  </TR>
					</TABLE>
					 
				  </FORM>
				</TD>
				 </TR>
			</TABLE>

		</TD>
	</TR>
</TABLE>
<IFRAME NAME="VerDat" SRC="" WIDTH="50" HEIGHT="50" FRAMEBORDER="0" STYLE="display: none;" allowtransparency>
	Tu navegador no soporta iframes!!!
</IFRAME>
<FORM NAME="frmReenvio" METHOD="post" TARGET="" ACTION="">
	<INPUT TYPE="hidden" NAME="CveJuzgado" VALUE="">
	<INPUT TYPE="hidden" NAME="TipoDatos" VALUE="Ini">
	<INPUT TYPE="hidden" NAME="nickname" VALUE="">
	<INPUT TYPE="hidden" NAME="Pagina" VALUE="">
	<INPUT TYPE="hidden" NAME="Menu" VALUE="">
</FORM>
<?php
mysql_close($link);
?>
</BODY>
</HTML>
