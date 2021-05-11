<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $IdRecibo = "";
    if(isset($_POST["IdRecibo"])){
        $IdRecibo = trim($_POST["IdRecibo"]); 
        if ($IdRecibo == ""){
            if(isset($_GET["IdRecibo"])){
                $IdRecibo = $_GET["IdRecibo"];
                if ($IdRecibo == ""){
                    $IdRecibo = "";
                }
            }
        }
    }    
    else{ 
        if ($IdRecibo == ""){
            $IdRecibo = "";
        }
        if(isset($_GET["IdRecibo"])){ 
            $IdRecibo = $_GET["IdRecibo"];
            if ($IdRecibo == ""){
                $IdRecibo = "";
            }
        }    
    }
    header("Content-type: application/pdf");
    header("Content-Disposition: inline; filename=".$IdRecibo.".pdf");
    readfile("../recibos/".$IdRecibo.".pdf");
    ?>
</body>
</html>