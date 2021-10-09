<?php

require('../conexion/conexionDB.php');

$email = $studentEmail.".cbp.stt.ap";

$searchEmail = mysqli_query($mysqli, "SELECT correo FROM alumnos WHERE correo = '$email'");

if(mysqli_num_rows($searchEmail) > 0){
  echo '<script>swal("¡El correo ya existe en el registro!", "", "warning")</script>';
}else{
  $addStudent = mysqli_query($mysqli, "INSERT INTO alumnos(nombre, apellido, id_grado, correo, contrasenia, codigo, estado, id_rol)
            VALUES ('$studentName', '$studentLN', $idGrado, '$email', '$studentPassword', '$studentCode', 'activo', 3)");

  if($addStudent){
    echo '<script>
            localStorage.setItem("addUser", "false");
            window.location = window.location;
          </script>';
  }else{
    echo $mysqli->error;
  }
}