<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="shortcut icon" href="../img/faviconhome.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/clases.css">
  <title>Inicio</title>
</head>
<body>
  <?php 
    session_start();
    $userEmail = $_SESSION['userEmail'];

    if (!isset($userEmail)) {
      header('location:../index.php');
    }else{
      if(!str_contains($userEmail, '.tc.mt')){
        header('location:../index.php');
      }
    }

    $idMaestro = $_SESSION['userID'];
    $userName = $_SESSION['userName'];
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
        <a href="#">
          <div class="option__icon"><i class="fas fa-chalkboard-teacher"></i></div>
          <div class="option__title">Clases</div>
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
      <h3>Clases Asignadas</h3>
    </div>
    <div class="main__classes-container">
    <?php 
      require('../conexion/conexionDB.php');
      $query = mysqli_query($mysqli, "SELECT clase.id, clase.id_grado, catedras.catedra, grados.grado, grados.seccion FROM clase 
                                        JOIN maestros ON clase.id_maestro = maestros.id 
                                        JOIN catedras ON clase.id_catedra = catedras.id 
                                        JOIN grados ON clase.id_grado = grados.id 
                                        WHERE clase.id_maestro = $idMaestro");
      if(mysqli_num_rows($query) > 0){
        while($row=mysqli_fetch_array($query)){
          echo '<a class="container__class" href="./teacherClass.php?clase='.$row['id'].'&grado='.$row['id_grado'].'">
                  <div class="class__img">
                    <img src="../img/college_logo.png" alt="Blaise Pascal">
                  </div>
                  <div class="class__details">
                    <span>'.$row["catedra"].'</span><br>
                    <span>'.$row["grado"].' '.$row["seccion"].'</span>
                  </div>
                </a>';
        }
      } else{
        echo "Sin clases asignadas";
      }
      ?>
    </div>
  </main>
  <script src="../js/sidemenu.js"></script>
  <script src="../js/closeSession.js"></script>
</body>
</html>