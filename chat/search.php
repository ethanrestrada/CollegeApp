<?php
session_start();
require('../conexion/conexionDB.php');
$idUser = $_SESSION['userID'];

$searchUser = mysqli_real_escape_string($mysqli, $_POST["query"]);
$query = "SELECT coordinadores.id, coordinadores.nombre, coordinadores.apellido FROM coordinadores
          WHERE coordinadores.estado = 'activo' AND NOT coordinadores.id = $idUser 
          AND (nombre LIKE '%$searchUser%' OR apellido LIKE '%$searchUser%') UNION ";

if($searchUser != ""){
  if($idUser > 3000 && $idUser < 5000){
    $query .= "SELECT DISTINCT alumnos.id, alumnos.nombre, alumnos.apellido FROM clase 
              JOIN alumnos ON clase.id_grado = alumnos.id_grado 
              WHERE clase.id_maestro = $idUser
              AND alumnos.estado = 'activo' AND (nombre LIKE '%$searchUser%' OR apellido LIKE '%$searchUser%') UNION
              SELECT maestros.id, maestros.nombre, maestros.apellido FROM maestros 
              WHERE NOT maestros.id = $idUser
              AND (nombre LIKE '%$searchUser%' OR apellido LIKE '%$searchUser%') ORDER BY nombre";
  
  } elseif($idUser > 5000){
    $idGrado = $_SESSION['idGrado'];
    $query .= "SELECT DISTINCT maestros.id, maestros.nombre, maestros.apellido FROM clase 
                JOIN maestros ON clase.id_maestro = maestros.id 
                JOIN alumnos ON clase.id_grado = alumnos.id_grado
                WHERE alumnos.id_grado = $idGrado AND (maestros.nombre LIKE '%$searchUser%' OR maestros.apellido LIKE '%$searchUser%')
                UNION SELECT alumnos.id, alumnos.nombre, alumnos.apellido FROM alumnos WHERE alumnos.id_grado = $idGrado 
                AND NOT alumnos.id = $idUser AND (nombre LIKE '%$searchUser%' OR apellido LIKE '%$searchUser%')
                ORDER BY nombre";
  
  } else{
    $query .= "SELECT alumnos.id, alumnos.nombre, alumnos.apellido FROM alumnos 
              WHERE (nombre LIKE '%$searchUser%' OR apellido LIKE '%$searchUser%') UNION
              SELECT maestros.id, maestros.nombre, maestros.apellido FROM maestros 
              WHERE (nombre LIKE '%$searchUser%' OR apellido LIKE '%$searchUser%') ORDER BY nombre";
  }
  $users = "";
  $busqueda = mysqli_query($mysqli, $query);

  if(mysqli_num_rows($busqueda)){
    include('./users.php');
  }else{
    $users .= "<h3 class='search-status'>Ninguna coincidencia</h3>";
  }
  echo $users;
}