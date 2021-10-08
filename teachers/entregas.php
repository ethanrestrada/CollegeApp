<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="shortcut icon" href="../img/faviconhome.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/submitedTeacher.css">
  <title>Actividades</title>
</head>
<body>
<?php 
    session_start();
    $grado = $_GET['grado'];
    $clase = $_GET['clase'];
    $userEmail = $_SESSION['userEmail'];
    
    if(!isset($userEmail)){
      header('location:../index.php');
    }else{
      if(!str_contains($userEmail, '.tc.mt')){
        header('location:../index.php');
      }
    }

    if($grado == null || $clase == null){
      header('location:./teachersIndex.php');
    }
    $idUser = $_SESSION['userID'];
    $userName = $_SESSION['userName'];

    function grado($clase){
      require('../conexion/conexionDB.php');
      $query = mysqli_query($mysqli, "SELECT grado, seccion FROM clase 
                                      JOIN grados ON clase.id_grado = grados.id 
                                      WHERE clase.id = $clase");
      if($query){
        while($fila=mysqli_fetch_array($query)){
          echo $fila['grado'].' '.$fila['seccion'];
        }
      }else{
        echo $mysqli->error;
      }
    }
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
        <a href="./teacherClass.php?clase=<?php echo $clase; ?>&grado=<?php echo $grado ?>">
          <div class="option__icon"><i class="fas fa-address-book"></i></div>
          <div class="option__title">Actividades</div>
        </a>
      </li>
      <li class="active">
        <a href="./entregas.php?clase=<?php echo $clase; ?>&grado=<?php echo $grado ?>">
          <div class="option__icon"><i class="fas fa-book"></i></div>
          <div class="option__title">Entregas</div>
        </a>
      </li>
      <li>
        <a href="./studentsTable.php?clase=<?php echo $clase; ?>&grado=<?php echo $grado ?>"> 
          <div class="option__icon"><i class="fas fa-user"></i></div>
          <div class="option__title">Estudiantes</div>
        </a>
      </li>
      <li>
        <a href="./teachersIndex.php">
          <div class="option__icon"><i class="fas fa-arrow-alt-circle-left"></i></div>
          <div class="option__title">Regresar</div>
        </a>
      </li>
      <li>
        <h3><?php grado($clase) ?></h3>
      </li>
    </ul>
  </div> 
  <main>
    <div class="main__title">
      <h1>Actividades asignadas</h1>
    </div>
    <div class="main__activities">
      <?php 
        require('../conexion/conexionDB.php');
        $query = "SELECT tareas.id, tareas.titulo, tareas.entrega, catedras.catedra FROM tareas 
                  JOIN clase ON tareas.id_clase = clase.id
                  JOIN catedras ON clase.id_catedra = catedras.id
                  WHERE clase.id = $clase AND tareas.tipo='Tarea' ORDER BY tareas.id ASC";
        $result = mysqli_query($mysqli, $query);
        if($result){
          if(mysqli_num_rows($result) > 0){
            while($row=mysqli_fetch_array($result)){
              $entrega = date("d-m-Y", strtotime($row['entrega']));
      ?>
        <a class="activities_activity" href="./workAbout.php?clase=<?php echo $clase; ?>&grado=<?php echo $grado; ?>&tarea=<?php echo $row['id'];?>">
          <div class="activity__about">
            <h3 class="activity__title"><?php echo $row['titulo']; ?></h3>
            <span><?php echo $entrega; ?></span>
          </div>
          <span class="activity__catedra"><?php echo $row['catedra']; ?></span>
        </a>
      <?php
      }}else{
            echo "<h1 class='workStatus'>¡Sin actividades por entregar!</h1>";
          }
        }else{
          echo $mysqli->error;
        }
      ?>
    </div>
  </main>
  <script src="../js/sidemenu.js"></script>
  <script src="../js/closeSession.js"></script>
</body>
</html>