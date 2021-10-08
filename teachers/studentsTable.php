<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="shortcut icon" href="../img/faviconuser.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/usersTable.css">
  <link rel="stylesheet" href="../css/navigation.css">
  <title>Alumnos</title>
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

    $userName = $_SESSION['userName'];
    function catedra($clase){
      require('../conexion/conexionDB.php');
      $query = mysqli_query($mysqli, "SELECT catedras.catedra FROM clase 
                                      JOIN catedras ON clase.id_catedra = catedras.id
                                      WHERE clase.id = $clase");
      while($fila=mysqli_fetch_array($query)){
        echo $fila['catedra'];
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
      <h5><?php echo $userName;  ?></h5>
      <i class="fas fa-sign-out-alt" id="closeSession"></i>
    </div>
  </header>
  <div class="menu-options">
    <ul>
    <li>
        <a href="./teacherClass.php?clase=<?php echo $clase; ?>&grado=<?php echo $grado;?>">
          <div class="option__icon"><i class="fas fa-address-book"></i></div>
          <div class="option__title">Actividades</div>
        </a>
      </li>
      <li>
        <a href="./entregas.php?clase=<?php echo $clase; ?>&grado=<?php echo $grado ?>">
          <div class="option__icon"><i class="fas fa-book"></i></div>
          <div class="option__title">Entregas</div>
        </a>
      </li>
      <li class="active">
        <a href="./studentsTable.php?clase=<?php echo $clase; ?>&grado=<?php echo $grado;?>"> 
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
        <h3><?php catedra($clase); ?></h3>
      </li>
    </ul>
  </div>
<main>
    <div class="main__title">
      <?php 
        $id = $_GET["grado"];
        require('../conexion/conexionDB.php');
        $query = mysqli_query($mysqli, "SELECT grado, seccion FROM grados WHERE id = ".$id."");
        mysqli_set_charset($mysqli, "utf8");
        while($fila=mysqli_fetch_array($query)){
          $Grado = $fila["grado"];
          $Seccion = $fila["seccion"];
        }
      ?>
      <h3><?php echo "Alumnos de ".$Grado." ".$Seccion; ?></h3>
    </div>
    <div class="main__users">
      <?php
        $busqueda = mysqli_query($mysqli, "SELECT id, nombre, apellido, codigo FROM alumnos WHERE id_grado = $id 
                                            AND estado = 'activo' ORDER BY nombre ASC");
        mysqli_set_charset($mysqli, "utf8");
        $j=0;
        while($row=mysqli_fetch_array($busqueda)){
          $j++;
          ($j < 10) ? $i = "0".$j : $i = $j;
          $idAlumno = $row['id'];
          $Nombre = $row['nombre'];
          $Apellido = $row['apellido'];
          $Codigo = $row['codigo']; 
        ?>
        <div class="userContainerStudent">
          <span><?php echo $i.'. '.$Nombre.' '.$Apellido;?><span>
        </div>
      <?php } ?>
    </div>
  </main> 
  <script src="../js/sidemenu.js"></script>
  <script src="../js/closeSession.js"></script>
</body>
</html>