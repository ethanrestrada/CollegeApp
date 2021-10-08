<?php

require('../conexion/conexionDB.php');


$archivo =  $workAbout = mysqli_real_escape_string($mysqli, $_POST['archivo']);
$workTipo = $_POST['editTipo'];
$ruta = '../homework/workfiles/grado_'.$grado.'/';

if($_FILES['editFile']['name'] == ""){
  if($archivo == ""){
    $deleteFile = mysqli_query($mysqli, "SELECT code_file FROM tareas WHERE id = $idWork");
    while($row=mysqli_fetch_array($deleteFile)){
      $file = $row['code_file'];
    }
    if(file_exists($ruta.$file)){
      unlink($ruta.$file);
    }
    $query = "UPDATE tareas SET titulo = '$editName', descripcion = '$editAbout', code_file = 'null', 
              name_file = 'null', entrega = '$editDueTo', tipo='$workTipo', updated_at = now() WHERE id = $idWork";
    runQuery($query);
  }else{
    $query = "UPDATE tareas SET titulo = '$editName', descripcion = '$editAbout', entrega = '$editDueTo', 
              tipo='$workTipo', updated_at = now() WHERE id = $idWork";
    runQuery($query);
  }
} else {
  $limite_kb = 20000;
  $file_name = $_FILES['editFile']['name'];
  $deleteFile = mysqli_query($mysqli, "SELECT code_file FROM tareas WHERE id = $idWork");
    while($row=mysqli_fetch_array($deleteFile)){
      $file = $row['code_file'];
    }
    if(file_exists($ruta.$file)){
      unlink($ruta.$file);
    }
  
  if($_FILES['editFile']['size'] <= $limite_kb){
    $time = time();
    $file_explode = explode('.', $file_name);
    $file_ext = end($file_explode);
    $code_file = $time.'.'.$file_ext;
    
    if(!file_exists($ruta)){
      mkdir($ruta);
    }

    if(move_uploaded_file($_FILES['editFile']['tmp_name'], $ruta.$code_file)){
      $query = "UPDATE tareas SET titulo = '$editName', descripcion = '$editAbout', code_file = '$code_file', 
      name_file = '$file_name', entrega = '$editDueTo', tipo='$workTipo', updated_at = now() WHERE id = $idWork";
      runQuery($query);
    } 
  }else {
    echo '<script> swal("Error al subir el archivo", "El tamaño del archivo excede el permitido.", "error"); </script>';
  }
}  

function runQuery($query){
  include('../conexion/conexionDB.php');
  $update = mysqli_query($mysqli, $query);
  if($update){
    echo '<script>    
            localStorage.setItem("edit-work", "false");
            window.location.href = window.location.href;  
          </script>';
  }else{
    echo $mysqli->error;
  }
}