<?php 
require('../conexion/conexionDB.php');

$workTipo = $_POST['workTipo'];

if($_FILES['workFile']['name'] != ""){
  $limite_kb = 20000;
  $file_name = $_FILES['workFile']['name'];
  
  if($_FILES['workFile']['size'] <= $limite_kb){
    $time = time();
    $file_explode = explode('.', $file_name);
    $file_ext = end($file_explode);
    $code_file = $time.'.'.$file_ext;
    
    $ruta = '../homework/workfiles/grado_'.$grado.'/';

    if(!file_exists($ruta)){
      mkdir($ruta);
    }

    if(move_uploaded_file($_FILES['workFile']['tmp_name'], $ruta.$code_file)){
      $query = "INSERT INTO tareas(titulo, id_clase ,code_file, name_file, entrega, tipo, descripcion, updated_at) 
                VALUES ('$workName', $clase ,'$code_file', '$file_name', '$workDueTo', '$workTipo', '$workAbout', 'null')";
      runQuery($query);
    }
  } else{
    echo '<script> swal("Error al subir el archivo", "El tamaño del archivo excede el permitido.", "error"); </script>';
  }
  
} else{
  $query = "INSERT INTO tareas(titulo, id_clase, code_file, name_file, entrega, tipo, descripcion, updated_at) 
            VALUES ('$workName', $clase, 'null', 'null', '$workDueTo', '$workTipo','$workAbout', 'null')";
  runQuery($query);
}

  function runQuery($query){
    include('../conexion/conexionDB.php');
    $result = mysqli_query($mysqli, $query);
    if($result){
      echo '<script>
              document.getElementById("workName").value = "";
              document.getElementById("workAbout").value = "";
              localStorage.setItem("add-work", "false");
              window.location.href = window.location.href;
            </script>';
    }else{
      echo $mysqli->error;
    }
  }