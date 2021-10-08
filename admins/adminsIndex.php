<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../css/adminsIndex.css">
  <link rel="shortcut icon" href="../img/faviconhome.png" type="image/x-icon">
  <title>Inicio</title>
</head>
<body>
<?php 
  session_start();
  $userEmail = $_SESSION['userEmail'];
  $userName = $_SESSION['userName'];

  if (!isset($userEmail)) {
    header('location:../index.php');
  }else{
    if(!str_contains($userEmail, '.cr.admin')){
      header('location:../index.php');
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
      <li class="active">
        <a href="./adminsIndex.php">
          <div class="option__icon"><i class="fas fa-chalkboard-teacher"></i></div>
          <div class="option__title">Grados</div>
        </a>
      </li>
      <li>
        <a href="./teachersTable.php">
          <div class="option__icon"><i class="fas fa-user"></i></div>
          <div class="option__title">Maestros</div>
        </a>
      </li> 
      <li>
        <a href="./inactivos.php">
          <div class="option__icon"><i class="fas fa-user-lock"></i></div>
          <div class="option__title">Inactivos</div>
        </a>
      </li> 
      <li>
        <a href="../chat/chat.php">
          <div class="option__icon"><i class="fas fa-comment-alt"></i></div>
          <div class="option__title">Mensajes</div>
        </a>
      </li>
    </ul>
  </div>
  <main>
    <div class="main__title">
      <h3>Grados disponibles</h3>
    </div>
    <div class="main__grades-container">
      <?php
        require('../conexion/conexionDB.php');
        $busqueda = mysqli_query($mysqli, "SELECT * FROM grados");
        mysqli_set_charset($mysqli, "utf8");
        $i=0;
        while($row=mysqli_fetch_array($busqueda)){
          $i++;
          $id = $row['id'];
          $Grado = $row['grado'];
          $Seccion = $row['seccion'];
          echo '<a href="./studentsTable.php?id='.$id.'" class="grado-container__grado">
                  <div class="grado__img">
                    <img src="../img/college_logo.png" alt="Blaise Pascal">
                  </div>
                  <div class="grado__name">
                    <h5>'.$Grado.' '.$Seccion.'</h5>
                  </div>
                </a>';
        }
      ?>
    </div>
  </main>
  <script src="../js/closeSession.js"></script>
  <script src="../js/sidemenu.js"></script>
</body>
</html>