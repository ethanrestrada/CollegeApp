<?php
$idUser = $_POST['idUser'];

  require('../conexion/conexionDB.php');
  $cambiarInfo = mysqli_query($mysqli, "UPDATE alumnos SET nombre = '$userModifyFN', apellido = '$userModifyLN', codigo = '$userModifyCode' WHERE id = ".$idUser."");
  
  
  if($cambiarInfo){
    echo '<script>
            localStorage.setItem("table-edit", "false");
            window.location = window.location;
          </script>';
  }

?>