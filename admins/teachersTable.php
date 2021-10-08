<?php
  if(isset($_POST['aceptar'])){
    require('../conexion/conexionDB.php');
    $modifyTeacherFN = mysqli_real_escape_string($mysqli, $_POST['modifyTeacherFN']);
    $modifyTeacherLN = mysqli_real_escape_string($mysqli, $_POST['modifyTeacherLN']);
    $modifyTeacherCont = mysqli_real_escape_string($mysqli, $_POST['modifyTeacherCont']);
    $idUser = $_POST['idUser'];
  }
?>
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
  <title>Maestros</title>
</head>
<body>
<?php 
    session_start();
    $userEmail = $_SESSION['userEmail'];
    if (!isset($userEmail)) {
      header('location:../index.php');
    }else{
      if(!str_contains($userEmail, '.cr.admin')){
        header('location:../index.php');
      }
    }
    function name($userEmail){
      require('../conexion/conexionDB.php');
      $username = mysqli_query($mysqli,"SELECT nombre, apellido FROM coordinadores WHERE correo ='".$userEmail."'");
      while($fila=mysqli_fetch_array($username)){
        echo $fila['nombre'].' '.$fila['apellido'];
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
      <h5><?php name($userEmail); ?></h5>
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
      <li class="active">
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
      <h3>Maestros Blaise Pascal</h3>
    </div>
    <div class="main__users">
    <?php
      require('../conexion/conexionDB.php');
      $busqueda = mysqli_query($mysqli, "SELECT id, nombre, apellido, contacto FROM maestros WHERE estado = 'activo' ORDER BY Nombre ASC");
      mysqli_set_charset($mysqli, "utf8");
      $j=0;
      while($row=mysqli_fetch_array($busqueda)){
        $j++;
        ($j < 10) ? $i = "0".$j : $i = $j;
        $idMaestro = $row['id'];
        $Nombre = $row['nombre'];
        $Apellido = $row['apellido'];
        $Contacto = $row['contacto']; 
      ?>
        <div class="userContainer">
          <div>
            <input type="hidden" name="userInfo" id='<?php echo $idMaestro; ?>' class="nombre" value='<?php echo $Nombre; ?>'>
            <input type="hidden" name="userInfo" id='<?php echo $idMaestro; ?>' class="apellido" value='<?php echo $Apellido; ?>'>
            <input type="hidden" name="userInfo" id='<?php echo $idMaestro; ?>' class="codigo" value='<?php echo $Contacto; ?>'>
            <span><?php echo $i.'. '.$Nombre.' '.$Apellido;?><span>
          </div>
          <div class="userButtons">
            <button id="<?php echo $idMaestro; ?>" class="edit"><i class="fas fa-pencil-alt"></i></button>
            <button id="<?php echo $idMaestro; ?>" class="delete"><i class="fas fa-trash"></i></button>
          </div>
        </div>
      <?php } ?>
    </div>
  </main> 
  <div class="delete-back">
    <div class="delete__container-delete">
      <form action="" method="post">
        <div class="container-delete__title">
          <h3>¿Estas seguro que quieres eliminar al maestro de la lista?</h3>
          <input type="hidden" name="idUserDelete" id="idUserDelete">
        </div>
        <div class="container-delete__content">
          <h5>Si te equivocas puedes volver a activar la cuenta del usuario</h5>
        </div>
        <div class="container-delete__buttons">
          <input type="submit" id="aceptarDelete" value="Aceptar" name="aceptarDelete">
          <input type="button" id="cancelarDelete" value="Cancelar">
        </div>
        <?php
          if(isset($_POST['aceptarDelete'])){
            include('../editTable/deleteTeacher.php');
          }
        ?>
      </form>
    </div>
  </div>
  <div class="modify-table-back">
    <div class="modify__container-modify">
      <form action="" method="post" autocomplete="off">
        <div class="container-modify__title">
          <h3 id="modifyTitle">Modifica la informacion del maestro</h3>
        </div>
        <div class="container-modify__name">
          <label for="nombreUsuario">Nombre</label>
          <input type="text" name="modifyTeacherFN" id="userModifyInfo" value="<?php if(isset($_POST['modifyTeacherFN'])){ echo $modifyTeacherFN; }?>">
          <input type="hidden" name="idUser" id="idUser" value="<?php if(isset($_POST['idUser'])){ echo $idUser; }?>">
        </div>
        <div class="container-modify__apellido">
          <label for="apellidoUsuario">Apellido</label>
          <input type="text" name="modifyTeacherLN" id="userModifyInfo" value="<?php if(isset($_POST['modifyTeacherLN'])){ echo $modifyTeacherLN; }?>">
        </div>
        <div class="container-modify__codigo">
          <label for="codigoUsuario">Contacto</label>
          <input type="text" name="modifyTeacherCont" id="userModifyInfo" value="<?php if(isset($_POST['modifyTeacherCont'])){ echo $modifyTeacherCont; }?>">
        </div>
        <div class="container-modify__buttons">
          <input type="submit" id="aceptarModify" value="Aceptar" name="aceptar">
          <input type="button" id="cancelarModify" value="Cancelar">
        </div>
        <?php
          if(isset($_POST['aceptar'])){
            if(empty($_POST['modifyTeacherFN']) || empty($_POST['modifyTeacherLN']) || empty($_POST['modifyTeacherCont'])){
              echo '<script>swal("No puedes dejar ningun campo vacio", "", "warning")</script>';
            }else{
              include('../editTable/editTeacher.php');
            }
          }
        ?>
      </form>
    </div>
  </div>
  <script src="../js/sidemenu.js"></script>
  <script src="../js/editTableUsers.js"></script>
  <script src="../js/closeSession.js"></script>
</body>
</html>