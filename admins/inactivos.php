<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../img/faviconuser.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../css/inactivos.css">
  <title>Usuarios inactivos</title>
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
      <li>
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
      <li class="active">
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
      <h3>Usuarios inactivos</h3>
    </div>
    <div class="main__container-users">
      <?php 
        require('../conexion/conexionDB.php');
        
        $query = mysqli_query($mysqli, "SELECT alumnos.id ,alumnos.nombre, alumnos.apellido, alumnos.id_rol, 
                                        grados.grado, grados.seccion FROM alumnos
                                        JOIN grados ON grados.id = alumnos.id_grado
                                        WHERE alumnos.estado = 'inactivo'
                                        UNION SELECT maestros.id, maestros.nombre, maestros.apellido, maestros.id_rol,
                                        maestros.contacto, maestros.correo FROM maestros WHERE maestros.estado = 'inactivo'");
        if($query){
        if(mysqli_num_rows($query) > 0){
          $j = 0;
          $l = 0;
          while($row=mysqli_fetch_array($query)){
            if($row['id_rol'] == 2){
              $l++;
              ($l < 10) ? $k = '0'.$l : $k = $l;
      ?>
        <div class="user-container teacher" id="<?php echo $row['id']; ?>">
          <div class="student-info">
            <div class="student-number">
              <span><?php echo $k; ?></span>
            </div>
            <div class="student-about">
              <span><?php echo $row['nombre'].' '.$row['apellido']; ?></span><br>
              <span><?php echo $row['grado']; ?></span>
            </div>
          </div>
          <button class="active-icon"><i class="fas fa-clipboard-check"></i></button>
        </div>
      <?php } 
        if($row['id_rol'] == 3){ 
          $j++;
          ($j < 10) ? $i = '0'.$j : $i = $j;
      ?>
        <div class="user-container student" id="<?php echo $row['id']; ?>">
          <div class="student-info">
            <div class="student-number">
              <span><?php echo $i; ?></span>
            </div>
            <div class="student-about">
              <span><?php echo $row['nombre'].' '.$row['apellido']; ?></span><br>
              <span><?php echo $row['grado'].' '.$row['seccion']; ?></span>
            </div>
          </div>
          <button class="active-icon"><i class="fas fa-clipboard-check"></i></button>
        </div>
      <?php
        }
      }}else{
        echo '<h1 class="userStatus">¡Sin cuentas inactivas!</h1>';
      }
    }else{
          echo $mysqli->error;
        }
      ?>
    </div>
    <input type="hidden" id="id_user">
  </main>
  <div class="active-user-back">
    <div class="active-user-container">
      <div class="active__title">
        <h3>Confirmar reactivacion de cuenta</h3>
      </div>
      <div class="active__about">
        <span>Podras volver a desactivar la cuenta del usuario si lo deseas</span>
      </div>
      <div class="active__buttons">
        <button class="confirm" onclick="confirmActive()">Aceptar</button>
        <button class="cancel" onclick="cancelActive()">Cancelar</button>
      </div>
    </div>
  </div>
  <script src="../js/closeSession.js"></script>
  <script src="../js/sidemenu.js"></script>
  <script src="../js/inactivo.js"></script>
</body>
</html>