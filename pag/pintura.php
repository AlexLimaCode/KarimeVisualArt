<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Obras de Pintura
	</title>
	<!-- FONT AWESOME -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="author" content="Alejandro Lima">
	<meta name="generator" content="Wordpress 5.0">
	<meta name="copyright" content="">
	<meta name="robots" content="index, follow">
	<meta name="keywords" content="EJEMPLO">
	<meta name="description" content="Sitio web de venta de arte">

	<!-- LINKEO EL FONT -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Xanh+Mono:ital@0;1&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald&display=swap" rel="stylesheet">
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/vendor.css">
    <link rel="stylesheet" href="../css/main.css">
    

    <!-- script
    ================================================== -->
    <script src="../js/modernizr.js"></script>
    <script src="../js/pace.min.js"></script>

    <!-- favicons
    ================================================== -->
    <link rel="shortcut icon" href="../icon.ico" type="image/x-icon">
    <link rel="icon" href="../icon.ico" type="image/x-icon">

</head>
<body>
		 <!-- header
    ================================================== -->
    <header class="s-header">

        <div class="header-logo">
            <a class="site-logo" href="../index.html">
                <img src="../images/logok.png" alt="Homepage">
            </a>
        </div>

        <nav class="header-nav">

            <a href="#" class="header-nav__close" title="close"><span>Close</span></a>

            <div class="header-nav__content">
                <h3>MENU</h3>
                
                <ul class="header-nav__list">
                    <li class="current"><a href="../index.html" title="home">Inicio</a></li>
                    <li><a href="../index.html" title="about">Artista</a></li>
                    <li><a href="../index.html" title="services">Tipos de Obras</a></li>
                    <li><a href="../index.html" title="works">Algunas Obras</a></li>
                    <li><a href="./pintura.php">Pintura</a></li>
                    <li><a href="./grabado.php" title="Grabado">Grabado</a></li>
                    <li><a href="./ilustracion.php" title="Ilustracion">Ilustracion</a></li>
                    <li><a href="../index.html" title="contact">Contacto</a></li>
                    <li><a href="./inicio.php" title="admin">Admin</a></li>
                </ul>
    
                <p>El arte no cambia nada, el arte te cambia a ti.</p>
    
                <ul class="header-nav__social">
                    <li>
                        <a href="https://www.facebook.com/karimevisualart-110700823899997/"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/karimevisualart/?hl=es"><i class="fa fa-instagram"></i></a>
                    </li>
                </ul>

            </div> <!-- end header-nav__content -->

        </nav>  <!-- end header-nav -->

        <a class="header-menu-toggle" href="#">
            <span class="header-menu-text">Menu</span>
            <span class="header-menu-icon"></span>
        </a>

    </header> <!-- end s-header -->
	<br>
	<br>
	<section id="galeria" class="container">
        <div class="text-center">
            <h1 style="color:white;">OBRAS DE LA SECCION DE PINTURA</h1>
            <p style="color:white;">Selecciona la obra de la que deseas conocer mas detalles o comprarla</p>
        </div>
		
		<div class="row">
			<?php
			include('./conexion.php');
			$query = "select RutaImagen, nomObra, o.IdObra from tblimagenes i, tblobrasarte o, tbltiposobras t where o.CveTipo = t.CveTipo and i.IdObra = o.IdObra and t.Nomtipo='Pintura' and o.CveEstatus=1 group by nomObra order by o.IdObra";
			$result = mysqli_query($conn,$query);
			if(mysqli_num_rows($result)>0){
				$info_campo = mysqli_fetch_fields($result);
				$i=0;
				foreach ($info_campo as $valor) {
					if ($i==0){
						$info = $valor->name;	
					}
					$i=$i+1;
				}
				$Columnas = $i; 
				$anterior="";
                    while($row=mysqli_fetch_array($result)){
                        if($row[2]==$anterior){
                        }else{
							echo"<div class='col-lg-4 col-md-6 col-sm img-fluid'>";
                            echo	"<a href=muestraObra.php?IdObra=".$row[2]."&NomTipo=Pintura><img src='../images/obras/".$row[0]."'></a>";
                            echo "<h1 style='color:white; text-align:center;'>".$row[1]."</h1>";
							echo"</div>";
                            $anterior=$row[2];
                        }
                        
                    }
				
			}else{
				
			}
			
			?>
		</div>
    </section>

	
    <!-- footer
    ================================================== -->
    <footer>

        <div class="row footer-main">

            <div class="col-six tab-full left footer-desc">

                <div class="footer-logo"></div>
                VisualArt es una empresa dedicada a la venta y promocion de las artes visuales, con el objetivo de expresar elegancia y felicidad a través de sus obras.

            </div>

            <div class="col-six tab-full right footer-subscribe">

                <h4>Contacto</h4>
                <p>Escribenos:</p>
                <a href="https://api.whatsapp.com/send?phone=525514869228"><i class="fa fa-whatsapp" aria-hidden="true"></i><span> Whatsapp</span></a>
                <br>
                <a href="https://www.facebook.com/karimevisualart-110700823899997/"><i class="fa fa-facebook" aria-hidden="true"></i><span> Facebook</span></a>
                <br>
                <a href="https://www.instagram.com/karimevisualart/?hl=es"><i class="fa fa-instagram" aria-hidden="true"></i><span> Instagram</span></a>
                    
            </div>

        </div> <!-- end footer-main -->

        <div class="row footer-bottom">

            <div class="col-twelve">
                <div class="copyright">
                    <span>© Copyright VisualArt 2021</span> 
                    <span>Creado por <a href="https://www.zeetech.com.mx">ZeeTech</a></span>	
                </div>

                <div class="go-top">
                    <a class="smoothscroll" title="Back to Top" href="#top"><i class="icon-arrow-up" aria-hidden="true"></i></a>
                </div>
            </div>

        </div> <!-- end footer-bottom -->

    </footer> <!-- end footer -->


    <!-- photoswipe background
    ================================================== -->
    <div aria-hidden="true" class="pswp" role="dialog" tabindex="-1">

        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">

            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div><button class="pswp__button pswp__button--close" title="Close (Esc)"></button> <button class="pswp__button pswp__button--share" title=
                    "Share"></button> <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button> <button class="pswp__button pswp__button--zoom" title=
                    "Zoom in/out"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div><button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button> <button class="pswp__button pswp__button--arrow--right" title=
                "Next (arrow right)"></button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>

        </div>

    </div> <!-- end photoSwipe background -->


    <!-- preloader
    ================================================== -->
    <div id="preloader">
        <div id="loader">
            <div class="line-scale-pulse-out">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>


    <!-- Java Script
    ================================================== -->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/plugins.js"></script>
    <script src="../js/main.js"></script>
	<!-- JS Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>