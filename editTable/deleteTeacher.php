<?php
$idUserDelete = $_POST['idUserDelete'];
  require('../conexion/conexionDB.php');
  $cambiarInfo = mysqli_query($mysqli, "UPDATE maestros SET estado = 'inactivo' WHERE id = $idUserDelete");

  if($cambiarInfo){
    echo '<script> 
            window.location = window.location;
          </script>';
  }

?>