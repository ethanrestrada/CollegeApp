<?php
  $idUser = $_POST['idUser'];

  require('../conexion/conexionDB.php');
  $cambiarInfo = mysqli_query($mysqli, "UPDATE maestros SET nombre = '$modifyTeacherFN', apellido = '$modifyTeacherLN', contacto = '$modifyTeacherCont' WHERE id = $idUser");

  if($cambiarInfo){
    echo '<script>
            localStorage.setItem("table-edit", "false");
            window.location = window.location;
          </script>';
  }
?>