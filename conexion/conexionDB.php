<?php
    $mysqli = new MysQli("localhost", "root", "","cbp");
    if($mysqli-> connect_errno){
        die("Fallo en la conexion a la base de datos:(".$mysqli-> mysqli_connect_errno().")".$mysqli->mysqli_connect_error());
    } 
?>