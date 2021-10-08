<?php

session_start();
require('../conexion/conexionDB.php');

$idStudent = $_SESSION['userID'];
$idGrado = $_SESSION['idGrado'];
$idTarea = $_POST['idTarea'];
$archivo = mysqli_real_escape_string($mysqli, $_POST['archivo']);
$limite_kb = 20000;
$ruta = './submitFiles/grado_'.$idGrado.'/';

$query1 = mysqli_query($mysqli, "SELECT code_file, name_file, estado FROM entregas 
                                WHERE id_tarea = $idTarea AND id_alumno = $idStudent");

if(mysqli_num_rows($query1) == 0){
  if($_FILES['file']['name'] == ""){
    $query =  "INSERT INTO entregas(id_tarea, id_alumno, code_file, name_file, estado) 
              VALUES ($idTarea, $idStudent, 'null', 'null', 'entregado')";
    runQuery($query);
  }else{
  
    $file_name = $_FILES['file']['name'];
    
    if($_FILES['file']['size'] <= $limite_kb){
      $time = time();
      $file_explode = explode('.', $file_name);
      $file_ext = end($file_explode);
      $code_file = $time.'.'.$file_ext;

      if(!file_exists($ruta)){
        mkdir($ruta);
      }
  
      if(move_uploaded_file($_FILES['file']['tmp_name'], $ruta.$code_file)){
        $query = "INSERT INTO entregas(id_tarea, id_alumno, code_file, name_file, estado) 
                  VALUES ($idTarea, $idStudent, '$code_file', '$file_name', 'entregado')";
        runQuery($query);
      }
    }else{
      echo '<span>Error al subir el archivo, el tamaño excede el permitido</span>';
    }
  }
}else{
  if($_FILES['file']['name'] == ""){
    if($archivo == ""){
      $deleteFile = mysqli_query($mysqli, "SELECT code_file FROM entregas WHERE id_tarea = $idTarea AND id_alumno = $idStudent");
      while($row=mysqli_fetch_array($deleteFile)){
        $file = $row['code_file'];
      }
      if(file_exists($ruta.$file)){
        unlink($ruta.$file);
      }

      $query = "UPDATE entregas SET code_file = 'null', name_file='null', estado = 'entregado', turnin_at = now() WHERE id_tarea = $idTarea AND id_alumno = $idStudent";
      runQuery($query);
    }else{
      $query = "UPDATE entregas SET estado ='entregado', turnin_at = now() WHERE id_tarea = $idTarea AND id_alumno = $idStudent";
      runQuery($query);
    }
  }else{
    $file_name = $_FILES['file']['name'];
    $deleteFile = mysqli_query($mysqli, "SELECT code_file FROM entregas WHERE id_tarea = $idTarea AND id_alumno = $idStudent");
      while($row=mysqli_fetch_array($deleteFile)){
        $file = $row['code_file'];
      }
      if(file_exists($ruta.$file)){
        unlink($ruta.$file);
      }
    
    if($_FILES['file']['size'] <= $limite_kb){
      $time = time();
      $file_explode = explode('.', $file_name);
      $file_ext = end($file_explode);
      $code_file = $time.'.'.$file_ext;
      
      if(!file_exists($ruta)){
        mkdir($ruta);
      }

      if(move_uploaded_file($_FILES['file']['tmp_name'], $ruta.$code_file)){
        $query = "UPDATE entregas SET code_file = '$code_file', name_file = '$file_name', estado = 'entregado', turnin_at = now() WHERE id_tarea = $idTarea AND id_alumno = $idStudent";
        runQuery($query);
      }
    }else{
      echo '<span>Error al subir el archivo, el tamaño excede el permitido</span>';
    }
  }
}

function runQuery($query){
  require('../conexion/conexionDB.php');
  $result = mysqli_query($mysqli, $query);
  if(!$result){
    echo $mysqli->error;
  }
}