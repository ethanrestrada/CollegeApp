<?php

session_start();
require('../conexion/conexionDB.php');

$idTarea = $_POST['idTarea'];
$idStudent = $_SESSION['userID'];

$cancelWork = mysqli_query($mysqli, "UPDATE entregas SET estado = 'cancelado' WHERE id_tarea = $idTarea 
                                    AND id_alumno = $idStudent");
if($cancelWork){
  echo '<script>
          document.getElementById("nameUploadFile").classList.remove("entregado");
        </script>';
}else{
  echo $mysqli->error;
}