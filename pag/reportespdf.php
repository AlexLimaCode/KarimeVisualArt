<?php
include('./conexion.php');

$fecha = $_POST['fecha'];
$mediante=$_POST['radio-stacked'];
$dias="";
$fechames="";
$fechaano="";
$suma=0;
$fechaActual = date('Y-m-d');

if ($mediante == "dia") {
    $mediante = "DIA";
    $dias = substr($fecha, 8,2);
    $query = "select MontoTotal from tblrecibos where FechaPago='".$fecha."'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_array($result)){
            $suma = $row[0]; 
        }
    }
}elseif ($mediante == "mes") {
    $mediante = "MES";
    //EXTRAIGO EL MES
    $fechames = substr($fecha, 5,2);
    $fechaano = substr($fecha, 0,4);
    $fechaano2 = (int) $fechaano;
    $fechaini = $fechaano."-".$fechames."-01";
    $fechafin = "";
    if ($fechames== "01" || $fechames== "03" || $fechames== "05" || $fechames== "07" || $fechames== "08" || $fechames== "10" || $fechames== "12") {
        $fechafin = $fechaano."-".$fechames."-31";
    }elseif ($fechames== "04" || $fechames== "06" || $fechames== "09" || $fechames== "11") {
        $fechafin = $fechaano."-".$fechames."-30";
    }elseif (($fechames== "02" && ($fechaano2%4==0 && $fechaano2%100!=0)) || ($fechames== "02" && $fechaano2%400==0)) {
        # bisiesto
        $fechafin = $fechaano."-".$fechames."-29";
    }elseif($fechames== "02"){
        $fechafin = $fechaano."-".$fechames."-28";
    }
    $dias = substr($fechafin, 8,2);
    $dias = (int) $dias;
    for ($i=1; $i < $dias; $i++) { 
        $query = "select MontoTotal from tblrecibos where FechaPago='".$fechaano."-".$fechames."-".$i."'";
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_array($result)){
                $suma = $row[0]; 
            }
        }
    }
    

}elseif($mediante == "ano"){
    $mediante = "AÑO";
    $fechaano = substr($fecha, 0,4);
    for ($i=1; $i <13 ; $i++) { 
        if ($i== "01" || $i== "03" || $i== "05" || $i== "07" || $i== "08" || $i== "10" || $i== "12") {
            for ($j=1; $j < 32; $j++) { 
                $query = "select MontoTotal from tblrecibos where FechaPago='".$fechaano."-".$i."-".$j."'";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_array($result)){
                        $suma = $row[0]; 
                    }
                }
            }
        }elseif ($i== "04" || $i== "06" || $i== "09" || $i== "11") {
            for ($j=1; $j < 31; $j++) { 
                $query = "select MontoTotal from tblrecibos where FechaPago='".$fechaano."-".$i."-".$j."'";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_array($result)){
                        $suma = $row[0]; 
                    }
                }
            }
        }elseif (($i== "02" && ($fechaano%4==0 && $fechaano%100!=0)) || ($i== "02" && $fechaano%400==0)) {
            # bisiesto
            for ($j=1; $j < 30; $j++) { 
                $query = "select MontoTotal from tblrecibos where FechaPago='".$fechaano."-".$i."-".$j."'";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_array($result)){
                        $suma = $row[0]; 
                    }
                }
            }
        }elseif($i== "02"){
            for ($j=1; $j < 29; $j++) { 
                $query = "select MontoTotal from tblrecibos where FechaPago='".$fechaano."-".$i."-".$j."'";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_array($result)){
                        $suma = $row[0]; 
                    }
                }
            }
        }
    }
}
require('./fpdf/fpdf.php');
      
    class PDF extends FPDF
    {
        
        // Cabecera de página
        function Header()
        {
            // Logo
            $this->Image('../images/logok.png',70,1,70);
            // Salto de línea
            $this->Ln(60);
            // Arial bold 15
            $this->SetFont('Arial','B',15);
            // Movernos a la derecha
            $this->Cell(50);
            // Título
            $this->Cell(90,10,'RECIBO DE VENTAS',1,0,'C');
            // Salto de línea
            $this->Ln(20);
        }

        // Pie de página
        function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,utf8_decode('Page ').$this->PageNo().'/1',0,0,'C');
        }
    }
    $doc = new PDF;
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    //Cell(width , height , text , border , end line , [align] )

    $pdf->Cell(130	,10,'VISUAL ART',0,0);
    $pdf->Cell(59	,10,utf8_decode('FECHA DE EXPEDICIÓN'),0,1);//end of line

    //set font to arial, regular, 12pt
    $pdf->SetFont('Arial','',12);

    $pdf->Cell(130	,5,utf8_decode('Karime Sánchez'),0,0);
    $pdf->Cell(59	,5,'',0,1);//end of line

    $pdf->Cell(130	,5,'',0,0);
    $pdf->Cell(25	,5,'Fecha: ',0,0);
    $pdf->Cell(34	,5,$fechaActual,0,1);//end of line

    


    //make a dummy empty cell as a vertical spacer
    $pdf->Cell(189	,10,'',0,1);//end of line

    

    //invoice contents
    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(105	,5,utf8_decode('RECIBO POR '.$mediante),1,0);
    $pdf->Cell(50	,5,'FECHA DE HOY',1,0);
    
    $pdf->Cell(34	,5,'Precio',1,1);//end of line
    
    $pdf->SetFont('Arial','',11);

    //Numbers are right-aligned so we give 'R' after new line parameter

    if ($mediante=="DIA") {
        
        $pdf->Cell(105	,20,$fecha,1,0);
    }elseif ($mediante=="MES") {
        $pdf->Cell(105	,20,$fechames."-".$fechaano,1,0);
    }elseif ($mediante=="AÑO") {
        $pdf->Cell(105	,20,$fechaano,1,0);
    }
    
    $pdf->Cell(50	,20,$fechaActual,1,0);
    $pdf->Cell(34	,20,'$'.$suma.'.00 MXN',1,1,'R');//end of line

    //summary
    $pdf->Cell(130	,5,'',0,0);
    $pdf->Cell(25	,5,'Subtotal',0,0);
    $pdf->Cell(4	,5,'$',1,0);
    $pdf->Cell(30	,5,$suma.'.00 MXN',1,1,'R');//end of line

    $pdf->Cell(130	,5,'',0,0);
    $pdf->Cell(25	,5,'Total',0,0);
    $pdf->Cell(4	,5,'$',1,0);
    $pdf->Cell(30	,5,$suma.'.00 MXN',1,1,'R');//end of line

    $pdf->Cell(100	,10,'Intrucciones:',0,1);//end of line

    //add dummy cell at beginning of each line for indentation
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,'Descarga el PDF si lo deseas',0,1);
    
    $pdf->Output();
?>
