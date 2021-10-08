<?php
  session_start();
  $idGrado = $_SESSION['idGrado'];
  $clase = $_POST['clase'];

  require('../conexion/conexionDB.php');
  $query = mysqli_query($mysqli, "SELECT tareas.*, maestros.nombre, maestros.apellido FROM tareas 
                                  JOIN clase ON tareas.id_clase = clase.id
                                  JOIN maestros ON clase.id_maestro = maestros.id  
                                  WHERE clase.id = $clase ORDER BY tareas.id DESC");
    if(mysqli_num_rows($query) > 0){
      while($row=mysqli_fetch_array($query)){
      $entrega = date("d-m-Y", strtotime($row['entrega']));
      if($row['tipo'] == "Aviso"){
        $icon = '<i class="fas fa-info-circle"></i>';
      ?>
        <div class="activities__activity">
          <div class="activity__type" id=<?php echo $row['tipo']; ?>>
            <h3><?php echo $icon; ?></h3>
          </div>
          <div class="activity__teacher">
            <h3><?php echo $row['nombre'].' '.$row['apellido'];?></h3>
          </div>
          <div class="activity__date">
            <h5><?php echo $row["created_at"]; ?></h5>
          </div>
          <div class="activity__about">
            <h4><?php echo $row["titulo"]; ?></h4>
            <p><?php echo $row["descripcion"]; ?>
              <br><strong>Entrega: </strong><?php echo $entrega; ?>
            </p>
            <?php 
              if($row["code_file"] != "null"){
                echo '<a class="activity_file" href="../homework/workfiles/grado_'.$idGrado.'/'.$row["code_file"].'" download="cbp_'.$row["name_file"].'">';
                echo '<span><i class="fas fa-file"></i>'.$row["name_file"].'</span>';
                echo '<span><i class="fas fa-download"></i></span>';
                echo '</a>';
              }
            ?>
          </div>
        </div>
        <?php }else{ $icon = '<i class="far fa-clipboard"></i>'; ?>
        <a class="activities__activity" href="./submitWorkAbout.php?tarea=<?php echo $row['id']?>">
          <div class="activity__type" id=<?php echo $row['tipo']; ?>>
            <h3><?php echo $icon; ?></h3>
          </div>
          <div class="activity__title-date">
            <h3><?php echo $row['titulo'] ?></h3>
            <span><?php echo $entrega; ?></span>
          </div>
          <div class="activity-teacher">
            <span><?php echo $row['nombre'].' '.$row['apellido']; ?></span>
          </div>
        </a>
      <?php
          }}}
          else{
            echo "<h1 class='workStatus'>¡Sin actividades programadas!</h1>";
          }
      ?>