<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="shortcut icon" href="../img/faviconhome.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/clases.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <title>Inicio</title>
</head>
<body>
  <?php 
    session_start();
    $userName = $_SESSION['userName'];
    $idStudent = $_SESSION['userID'];
    $userEmail = $_SESSION['userEmail'];
    if (!isset($userEmail)) {
      header('location:../index.php');
    }else{
      if(!str_contains($userEmail, '.stt.ap')){
        header('location:../index.php');
      }
    }

    require('../conexion/conexionDB.php');
    $searchGrado = mysqli_query($mysqli, "SELECT id_grado FROM alumnos WHERE id = $idStudent");
    while($fila=mysqli_fetch_array($searchGrado)){
      $idGrado = $fila['id_grado'];
    }
    $_SESSION['idGrado'] = $idGrado; 
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
        <a href="./studentsIndex.php">
          <div class="option__icon"><i class="fas fa-chalkboard-teacher"></i></div>
          <div class="option__title">Clases</div>
        </a>
      </li>
      <li>
        <a href="./entregas.php">
          <div class="option__icon"><i class="fas fa-book"></i></div>
          <div class="option__title">Entregar</div>
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
      $query = mysqli_query($mysqli, "SELECT clase.id, clase.id_catedra, catedras.catedra FROM clase
                                      JOIN catedras ON clase.id_catedra = catedras.id
                                      WHERE clase.id_grado = ".$_SESSION['idGrado']." ORDER BY catedra ASC");
      if(mysqli_num_rows($query) > 0){
        while($row=mysqli_fetch_array($query)){
          echo '<a class="container__class" href="./studentClass.php?clase='.$row["id"].'">
                  <div class="class__img">
                    <img src="../img/college_logo.png" alt="Blaise Pascal">
                  </div>
                  <div class="class__details">
                    <span>'.$row["catedra"].'</span>
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