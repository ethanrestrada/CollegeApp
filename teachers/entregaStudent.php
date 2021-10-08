<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="shortcut icon" href="../img/faviconhome.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/entregaStudent.css">
  <title>Entrega</title>
</head>
<body>
<?php
    session_start();
    require('../conexion/conexionDB.php');
    $userEmail = $_SESSION['userEmail'];
    $idTarea = $_GET['tarea'];
    $clase = $_GET['clase'];
    $grado = $_GET['grado'];
    $idStudent = $_GET['alumno'];

    if (!isset($userEmail)) {
      header('location:../index.php');
    }else{
      if(!str_contains($userEmail, '.tc.mt')){
        header('location:../index.php');
      }
    }
    if($grado == null || $clase == null){
      header('location:./teachersIndex.php');
    }else{
      if($idTarea == null){
        header('location:./entregas.php?clase='.$clase.'&grado='.$grado.''); 
      }else{
        if($idStudent == null){
          header('location:./workAbout.php?clase='.$clase.'&grado='.$grado.'&tarea='.$idTarea.'');        
        }
      }
    }

    $userName = $_SESSION['userName'];
    $idUser = $_SESSION['userID'];
  ?>
  <header>
    <div class="header__menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
    <div class="header__college-logo">
      <img src="../img/college_logo.png" alt="Blaise Pascal">
    </div>
    <div class="header__user-options">
      <h5><?php echo $userName; ?></h5>
    <i class="fas fa-sign-out-alt" id="closeSession"></i>
    </div>
  </header>
  <div class="menu-options">
    <ul>
      <li>
        <a href="./workAbout.php?clase=<?php echo $clase; ?>&grado=<?php echo $grado ?>&tarea=<?php echo $idTarea; ?>">
          <div class="option__icon"><i class="fas fa-arrow-circle-left"></i></div>
          <div class="option__title">Regresar</div>
        </a>
      </li> 
    </ul>
  </div>
  <main>
    <div class="activity-container">
      <?php 
        $query = mysqli_query($mysqli, "SELECT * FROM tareas WHERE id = $idTarea");
        while($row=mysqli_fetch_array($query)){
          $entrega = date("d-m-Y", strtotime($row['entrega']));
          ($row['updated_at'] != "null") ? $modified = '<strong>Modificada: </strong>'.$row['updated_at'] : $modified = '';
      ?>
      <div class="activity__title">
        <h1><?php echo $row['titulo']; ?></h1>
      </div>
      <div class="activity__date">
        <span><strong>Entrega:</strong> <?php echo $entrega; ?></span>
      </div>
      <div class="activity__about">
        <p><?php echo $row['descripcion']; ?></p>
        <span><strong>Asignada:</strong> <?php echo $row['created_at']; ?></span>
        <span><?php echo $modified ?></span>
        <?php 
          if($row['code_file'] != "null"){
        ?>
          <a class="activity__file" href="../homework/workfiles/grado_<?php echo $grado; ?>/<?php echo $row['code_file'];?>" download="cbp_<?php echo $row['name_file']; ?>">
            <span><i class="fas fa-file"></i><?php echo $row['name_file']; ?></span>
            <span><i class="fas fa-download"></i></span>      
          </a>
        <?php } ?>
      </div>
      <div class="turnin-work">
        <?php } 
          $query2 = "SELECT alumnos.nombre, alumnos.apellido, code_file, name_file, turnin_at FROM  entregas
                    JOIN alumnos ON alumnos.id = entregas.id_alumno
                    WHERE entregas.id_tarea = $idTarea AND entregas.id_alumno = $idStudent";
          $result = mysqli_query($mysqli, $query2);
          while($row2=mysqli_fetch_array($result)){
        ?>
        <span class="studentName"><?php echo $row2['nombre'].' '.$row2['apellido']; ?></span>
        <?php 
          if($row2['code_file'] != 'null'){
        ?>
        <a class="activity__file" href="../homework/submitFiles/grado_<?php echo $grado; ?>/<?php echo $row2['code_file'];?>" download="cbp_<?php echo $row2['name_file']; ?>">
          <span><i class="fas fa-file"></i><?php echo $row2['name_file']; ?></span>
          <span><i class="fas fa-download"></i></span>      
        </a>
        <?php } ?>
        <br><span><?php echo '<strong>Entregada: </strong>'.$row2['turnin_at']; ?></span>
        <?php } ?>
      </div>
    </div>
  </main>
  <script src="../js/sidemenu.js"></script>
  <script src="../js/closeSession.js"></script>
</body>
</html>