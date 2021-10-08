<?php 

require('../conexion/conexionDB.php');

$idWork = $_POST['idWorkDelete'];
$ruta = '../homework/workfiles/grado_'.$grado.'/';

$deleteFile = mysqli_query($mysqli, "SELECT code_file FROM tareas WHERE id = $idWork");
while($row=mysqli_fetch_array($deleteFile)){
  $file = $row['code_file'];
}
if($file != 'null'){
  unlink($ruta.$file);
}
$searchEntrega = mysqli_query($mysqli, "SELECT * FROM entregas WHERE id_tarea = $idWork");
if(mysqli_num_rows($searchEntrega) > 0){
  $deleteEntrega = mysqli_query($mysqli, "DELETE FROM entregas WHERE id_tarea = $idWork");
}

$deleteWork = mysqli_query($mysqli, "DELETE FROM tareas WHERE id = $idWork");

if($deleteWork){
  echo '<script>
          window.location.href = window.location.href;
        </script>';
}else{
  echo $mysqli->error;
}