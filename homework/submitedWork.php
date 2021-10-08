<?php

require('../conexion/conexionDB.php');
$id_tarea = $_POST['id_tarea'];
$id_clase = $_POST['id_clase'];
$id_grado = $_POST['id_grado'];  

$query = mysqli_query($mysqli, "SELECT alumnos.id, alumnos.nombre, alumnos.apellido FROM entregas
                                JOIN alumnos ON alumnos.id = entregas.id_alumno
                                WHERE entregas.id_tarea = $id_tarea AND entregas.estado = 'entregado'");
if($query){
  if(mysqli_num_rows($query) > 0){
    echo '<h1 class="workStatus">Entregas: </h1>';
    while($row=mysqli_fetch_array($query)){
?>
  <a href="./entregaStudent.php?clase=<?php echo $id_clase; ?>&grado=<?php echo $id_grado ?>&tarea=<?php echo $id_tarea;?>&alumno=<?php echo $row['id']; ?>" class="student">
    <span><?php echo $row['nombre'].' '.$row['apellido']; ?></span>
  </a>
<?php
    }
  }else{
    echo '<h1 class="workStatus">Sin entregas</h1>';
  }
}else{
  echo $mysqli->error;
}
