<?php
$idUserDelete = $_POST['idUserDelete'];

  require('../conexion/conexionDB.php');
  $desactivarUsuario = mysqli_query($mysqli, "UPDATE alumnos SET estado = 'inactivo' WHERE id = $idUserDelete");

  if($desactivarUsuario){
    echo '<script> 
            window.location = window.location;
          </script>';
  }
?>