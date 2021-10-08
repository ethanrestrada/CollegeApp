<?php 

require('../conexion/conexionDB.php');
$idUser = $_POST['id_user'];

if($idUser > 3000 && $idUser < 5000){
  $query = "UPDATE maestros SET estado = 'activo' WHERE id = $idUser";
}elseif($idUser > 5000){
  $query = "UPDATE alumnos SET estado = 'activo' WHERE id = $idUser";
}

$result = mysqli_query($mysqli, $query);