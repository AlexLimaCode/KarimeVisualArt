<?php
    
    include('./conexion.php');
    //Datos del comprador
    $IdObra = $_POST['IdObra'];
    $nombre = $_POST['name'];
    $apellidop = $_POST['apep'];
    $apellidom = $_POST['apem'];      
    $correo = $_POST['mail'];         
    $telefono = $_POST['tel'];           
    $direc = $_POST['dir'];
    $estado = $_POST['estado'];
    $numero = $_POST['num'];
    $cp = $_POST['cp'];

    $query5 = "Update tblobrasarte set CveEstatus=3 where IdObra=".$IdObra;
    $result5 = mysqli_query($conn,$query5);

    $query2 = "insert into tblrecibos (IdEstatus, Nombre) values (1, 'nuevo')";
    $result2 = mysqli_query($conn,$query2);

    $query4 = "select IdRecibo from tblrecibos order by IdRecibo";
    $result4 = mysqli_query($conn,$query4);


    $j=1;
    if(mysqli_num_rows($result4)>0){
        while($row=mysqli_fetch_array($result4)){
            $j=$row[0];
        }
    }
    $IdRecibo = $j;
    $s = $j;
    $ruta = '../recibos/'.$j.'.pdf';
    $fechaActual = date('Y-m-d');
    

    $query = "select NomObra, FechaObra, PrecioObra, DesObra from tblimagenes i, tblobrasarte o, tbltiposobras t where o.CveTipo = t.CveTipo and i.IdObra = o.IdObra and o.IdObra=".$IdObra;
    $result = mysqli_query($conn,$query);
    $j=0;
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_array($result)){
            if($j==0){
                $nomObra = $row[0];
                $fechaObra = $row[1];
                $precioObra = $row[2];
                $desObra = $row[3];
            }  
        }
    }

    $query3 = "update tblrecibos set IdEstatus=1, Nombre='".$nombre."', Paterno='".$apellidop."', Materno='".$apellidom."', Direccion='".$direc." #".$numero." C.P.".$cp." , Estado: ".$estado." ,México', Correo='".$correo."', Telefono=".$telefono.", MontoTotal=".$precioObra.", FechaEmision='".$fechaActual."', ImagenRecibo='".$ruta."' where IdRecibo=".$s;

    $result3 = mysqli_query($conn,$query3);


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
            $this->Cell(90,10,'Ficha de Pago',1,0,'C');
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

    $pdf->Cell(130	,5,'Cuenta BBVA: 012180015076787289',0,0);
    $pdf->Cell(25	,5,'Fecha: ',0,0);
    $pdf->Cell(34	,5,$fechaActual,0,1);//end of line

    $pdf->Cell(130	,5,'Whatsapp [+52 1 55-1486-9228]',0,0);
    $pdf->Cell(25	,5,'No. Recibo',0,0);
    $pdf->Cell(34	,5,'#'.$IdRecibo,0,1);//end of line


    //make a dummy empty cell as a vertical spacer
    $pdf->Cell(189	,10,'',0,1);//end of line

    //billing address
    $pdf->Cell(100	,10,'Ficha de Referencia para:',0,1);//end of line

    //add dummy cell at beginning of each line for indentation
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,'Nombre del Cliente: '.$nombre.' '.$apellidop.' '.$apellidom,0,1);

    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,'Correo: '.$correo,0,1);

    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,utf8_decode('Dirección: '.$direc.' #'.$numero.' C.P. '.$cp),0,1);

    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,'Estado: '.$estado,0,1);

    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,utf8_decode('Teléfono: '.$telefono),0,1);
    //make a dummy empty cell as a vertical spacer
    $pdf->Cell(189	,10,'',0,1);//end of line

     //billing address
    $pdf->Cell(100	,10,'Detalles de la obra',0,1);//end of line
    
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,'Nombre de la obra: '.$nomObra,0,1);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,utf8_decode('Descripción de la obra: '.$desObra),0,1);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,'Fecha de la obra: '.$fechaObra,0,1);

    //make a dummy empty cell as a vertical spacer
    $pdf->Cell(189	,10,'',0,1);//end of line

    //invoice contents
    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(105	,5,'Obra',1,0);
    $pdf->Cell(50	,5,'Cantidad',1,0);
    $pdf->Cell(34	,5,'Precio',1,1);//end of line
    
    $pdf->SetFont('Arial','',11);

    //Numbers are right-aligned so we give 'R' after new line parameter

    $pdf->Cell(105	,20,$nomObra,1,0);
    $pdf->Cell(50	,20,'1',1,0);
    $pdf->Cell(34	,20,'$'.$precioObra.'.00 MXN',1,1,'R');//end of line

    //summary
    $pdf->Cell(130	,5,'',0,0);
    $pdf->Cell(25	,5,'Subtotal',0,0);
    $pdf->Cell(4	,5,'$',1,0);
    $pdf->Cell(30	,5,$precioObra.'.00 MXN',1,1,'R');//end of line

    $pdf->Cell(130	,5,'',0,0);
    $pdf->Cell(25	,5,'Total',0,0);
    $pdf->Cell(4	,5,'$',1,0);
    $pdf->Cell(30	,5,$precioObra.'.00 MXN',1,1,'R');//end of line

    $pdf->Cell(100	,10,'Intrucciones:',0,1);//end of line

    //add dummy cell at beginning of each line for indentation
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,'Descarga la ficha y realiza el deposito, envia una foto al Whatsapp indicado arriba.',0,1);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,'Un administrador se pondra en contacto contigo para los tramites de envio.',0,1);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(90	,5,'El precio indicado arriba NO incluye el envio.',0,1);

    $pdf->Output($ruta,'F');
    $pdf->Output();

    
?>