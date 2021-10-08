<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../img/faviconhome.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/studentClass.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>Clase</title>
</head>
<body>
<?php 
  session_start();
  $userEmail = $_SESSION['userEmail'];
  $clase = $_GET['clase'];

  if (!isset($userEmail)) {
    header('location:../index.php');
  }else{
    if(!str_contains($userEmail, '.stt.ap')){
      header('location:../index.php');
    }
  }
  if($clase == null){
    header('location:./studentsIndex.php');
  }
  
  $userName = $_SESSION['userName'];
  $idGrado = $_SESSION['idGrado'];
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
        <a href="./studentClass.php?clase=<?php echo $clase; ?>">
          <div class="option__icon"><i class="fas fa-address-book"></i></div>
          <div class="option__title">Avisos</div>
        </a>
      </li>
      <li>
        <a href="./studentsIndex.php">
          <div class="option__icon"><i class="fas fa-arrow-alt-circle-left"></i></div>
          <div class="option__title">Regresar</div>
        </a>
      </li>
    </ul>
  </div> 
  <main>
    <div class="main__title">
      <h1>Actividades programadas</h1>
      <input type="hidden" id="idCatedra" value="<?php echo $clase; ?>">
    </div>
    <div class="main__activities">
      <span class="loading"><i class="fas fa-spinner"></i>Cargando</span>
    </div>
  </main>
  <script src="../js/closeSession.js"></script>
  <script src="../js/sidemenu.js"></script>
  <script src="../js/studentActivity.js"></script>
</body>
</html>