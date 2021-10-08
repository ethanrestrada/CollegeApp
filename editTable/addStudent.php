<?php

require('../conexion/conexionDB.php');

$email = $studentEmail.".cbp.stt.ap";

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