<?php
    $conn = mysqli_connect("localhost","root", "","mibase");
    $result = mysqli_query($conn,"select IdObra from tblobrasarte");
    if (mysqli_num_rows($result)>0) {
        while($row=mysqli_fetch_array($result)){
            echo $row[0]."\n";
        }
    }
    
?>