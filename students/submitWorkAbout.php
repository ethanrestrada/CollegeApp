<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../img/faviconhome.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../css/submitWorkAbout.css">
  <title>Tarea</title>
</head>
<body>
  <?php
    session_start();
    require('../conexion/conexionDB.php');
    $userEmail = $_SESSION['userEmail'];
    $idTarea = $_GET['tarea'];

    if (!isset($userEmail)) {
      header('location:../index.php');
    }else{
      if(!str_contains($userEmail, '.stt.ap')){
        header('location:../index.php');
      }
    }
    if($idTarea == null){
      header('location:./entregas.php');
    }

    $userName = $_SESSION['userName'];
    $idGrado = $_SESSION['idGrado'];
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
        <a href="./entregas.php">
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
          <a class="activity__file" href="../homework/workfiles/grado_<?php echo $idGrado; ?>/<?php echo $row['code_file'];?>" download="cbp_<?php echo $row['name_file']; ?>">
            <span><i class="fas fa-file"></i><?php echo $row['name_file']; ?></span>
            <span><i class="fas fa-download"></i></span>      
          </a>
        <?php } ?>
      </div>
    <?php } 
      $query2 = mysqli_query($mysqli, "SELECT code_file, name_file, estado, turnin_at FROM entregas WHERE id_tarea = $idTarea 
                                        AND id_alumno = $idUser");
      $file = '';
      $estado = '';
      $name_file = '';
      $turnin_at = '';
      $submit = '<input type="submit" value="Entregar" id="entregar" name="submit">';
      if(mysqli_num_rows($query2) > 0){
        $submit = '<input type="submit" value="Deshacer entrega" id="undo" name="submit">';
        while($row2=mysqli_fetch_array($query2)){
          if($row2['code_file'] != 'null'){
            $file = '<div class="uploadFileName"><i class="fas fa-file"></i>'.$row2['name_file'].'</div><i class="far fa-times-circle" id="deleteFile2"></i>';
            $estado = 'active';
            $name_file = $row2['name_file'];
          }
          if($row2['estado'] == 'cancelado'){
            $submit = '<input type="submit" value="Entregar" id="entregar" name="submit">';
          }
          if($row2['estado'] == 'entregado'){
            $estado .= ' entregado';
            $turnin_at = '<span><strong>Entregada: </strong>'.$row2['turnin_at'].'</span>';
          }
        }
      }
    ?>
    <div class="activity__upload-file">
      <form action="" method="post" enctype="multipart/form-data">
        <label for="uploadFile" class="<?php echo $estado; ?>"><i class="far fa-plus-square"></i>Subir archivo</label>
        <input type="file" name="file" id="uploadFile">
        <div class="file-name">
          <span id="nameUploadFile" class="<?php echo $estado; ?>"><?php echo $file; ?></span>
          <input type="hidden" name="archivo" id="archivo" value="<?php echo $name_file; ?>">
        </div>
        <div class="upload-file">
          <input type="hidden" name="idTarea" id="idTarea" value="<?php echo $idTarea ?>">
          <span class="turnin_at"><?php echo $turnin_at; ?></span>
          <?php echo $submit; ?>
        </div>
      </form>
    </div>
    <div class="result"></div>
    </div>
  </main>
  <script src="../js/sidemenu.js"></script>
  <script src="../js/closeSession.js"></script>
  <script src="../js/submitWork.js"></script>
</body>
</html>