<?php 
  session_start();
  $idGrado = $_SESSION['idGrado'];

  $idUser = $_SESSION['userID'];
  require('../conexion/conexionDB.php');

  $query = "SELECT tareas.id, tareas.titulo, catedras.catedra, tareas.entrega FROM tareas 
            JOIN clase ON tareas.id_clase = clase.id
            JOIN catedras ON clase.id_catedra = catedras.id
            WHERE clase.id_grado = $idGrado AND tareas.tipo='Tarea' ORDER BY tareas.id ASC";
  $result = mysqli_query($mysqli, $query);
  
  if($result){
    if(mysqli_num_rows($result) > 0){
      while($row=mysqli_fetch_array($result)){
        $entrega = date("d-m-Y", strtotime($row['entrega']));
        $query2 = "SELECT entregas.id_tarea, entregas.id_alumno, entregas.estado, tareas.titulo FROM entregas
                  JOIN tareas ON tareas.id = entregas.id_tarea
                  JOIN clase ON clase.id = tareas.id_clase WHERE clase.id_grado = $idGrado AND entregas.id_alumno = $idUser 
                  AND entregas.id_tarea = ".$row['id']." ORDER BY tareas.id ASC";
        $result2 = mysqli_query($mysqli, $query2);
        if(mysqli_num_rows($result2) > 0){
          while($row2=mysqli_fetch_array($result2)){
            if(in_array($row2['id_tarea'], $row) && $row2['estado'] == 'cancelado'){
              echo '<a class="activities_activity entregar" href="./submitWorkAbout.php?tarea='.$row['id'].'">
                      <div class="activity__about">
                        <h3 class="activity__title">'.$row['titulo'].'</h3>
                        <span>'.$entrega.'</span>
                      </div>
                      <span class="activity__catedra">'.$row['catedra'].'</span>
                    </a>';
            }
            if(in_array($row2['id_tarea'], $row) && $row2['estado'] == 'entregado'){
              echo '<a class="activities_activity-finished" href="./submitWorkAbout.php?tarea='.$row['id'].'">
                      <div class="activity__about">
                        <h3 class="activity__title">'.$row['titulo'].'</h3>
                        <span>'.$entrega.'</span>
                      </div>
                      <span class="activity__catedra">'.$row['catedra'].'</span>
                    </a>';
            }
          }
        }else{
          echo '<a class="activities_activity entregar" href="./submitWorkAbout.php?tarea='.$row['id'].'">
                  <div class="activity__about">
                    <h3 class="activity__title">'.$row['titulo'].'</h3>
                    <span>'.$entrega.'</span>
                  </div>
                  <span class="activity__catedra">'.$row['catedra'].'</span>
                </a>';      
        }
      }
    }else{
      echo "<h1 class='workStatus'>¡Sin actividades por entregar!</h1>";
    }
  }else{
    echo $mysqli->error;
  }