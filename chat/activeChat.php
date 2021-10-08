<?php
  require('../conexion/conexionDB.php');
  $idUser = $_POST['idUser'];

  require('../conexion/conexionDB.php');
    $query = "SELECT DISTINCT maestros.id, maestros.nombre, maestros.apellido FROM chat 
              JOIN maestros ON chat.incoming_id = maestros.id OR chat.outgoing_id = maestros.id 
              WHERE (chat.outgoing_id = $idUser OR chat.incoming_id = $idUser) AND NOT maestros.id = $idUser UNION 
              SELECT DISTINCT alumnos.id, alumnos.nombre, alumnos.apellido FROM chat 
              JOIN alumnos ON chat.incoming_id = alumnos.id OR chat.outgoing_id = alumnos.id 
              WHERE (chat.outgoing_id = $idUser OR chat.incoming_id = $idUser) AND NOT alumnos.id = $idUser
              UNION SELECT DISTINCT coordinadores.id, coordinadores.nombre, coordinadores.apellido FROM chat 
              JOIN coordinadores ON chat.incoming_id = coordinadores.id OR chat.outgoing_id = coordinadores.id 
              WHERE (chat.outgoing_id = $idUser OR chat.incoming_id = $idUser) AND NOT coordinadores.id = $idUser";
    
    $users = mysqli_query($mysqli, $query);
    if(!$users){
      echo $mysqli->error;
    }
    $chatInfo = "";
    if(mysqli_num_rows($users) > 0){
      include('./getLastMsg.php');
    }
