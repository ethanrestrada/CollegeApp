<?php
  if(isset($_POST['aceptar'])){
    require('../conexion/conexionDB.php');
    $userModifyFN = mysqli_real_escape_string($mysqli, $_POST['userModifyFN']);
    $userModifyLN = mysqli_real_escape_string($mysqli, $_POST['userModifyLN']);
    $userModifyCode = mysqli_real_escape_string($mysqli, $_POST['userModifyCode']);
    $idStudent = mysqli_real_escape_string($mysqli, $_POST['idUser']);
  }
  if(isset($_POST['aceptarAdd'])){
    require('../conexion/conexionDB.php');
    $studentName = mysqli_real_escape_string($mysqli, $_POST['studentName']);
    $studentLN = mysqli_real_escape_string($mysqli, $_POST['studentLN']);
    $studentEmail = mysqli_real_escape_string($mysqli, $_POST['studentEmail']);
    $studentPassword = mysqli_real_escape_string($mysqli, $_POST['studentPassword']);
    $studentCode = mysqli_real_escape_string($mysqli, $_POST['studentCode']);
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <title>Alumnos</title>
</head>
<body>
<?php 
    session_start();
    $userEmail = $_SESSION['userEmail']; 
    $userName = $_SESSION['userName'];
    $idGrado = $_GET["id"];

    if (!isset($userEmail)) {
      header('location:../index.php');
    }else{
      if(!str_contains($userEmail, '.cr.admin')){
        header('location:../index.php');
      }
    }
    if($idGrado == null){
      header('location:./adminsIndex.php');
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
      <?php 
        require('../conexion/conexionDB.php');
        $Grado = '';
        $Seccion = '';
        $query = mysqli_query($mysqli, "SELECT grado, seccion FROM grados WHERE id = $idGrado");
        if(mysqli_num_rows($query) > 0){
          mysqli_set_charset($mysqli, "utf8");
          while($fila=mysqli_fetch_array($query)){
            $Grado = $fila["grado"];
            $Seccion = $fila["seccion"];
          }
        }
      ?>
      <h3><?php echo "Alumnos de ".$Grado." ".$Seccion; ?></h3>
    </div>
    <div class="main__add-user">
      <div class="add-user__container">
        <div class="add-user__icon">
          <i class="fas fa-plus"></i>
        </div>
        <div class="add-user__text">
          <h3>Agregar alumno</h3>
        </div>
      </div>
    </div>
    <div class="main__users">
      <?php
        $busqueda = mysqli_query($mysqli, "SELECT id, nombre, apellido, codigo FROM alumnos WHERE id_grado = ".$idGrado." AND estado = 'activo' ORDER BY nombre ASC");
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
        <div class="userContainer">
          <div>
            <input type="hidden" name="userInfo" id='<?php echo $idAlumno; ?>' class="nombre" value='<?php echo $Nombre; ?>'>
            <input type="hidden" name="userInfo" id='<?php echo $idAlumno; ?>' class="apellido" value='<?php echo $Apellido; ?>'>
            <input type="hidden" name="userInfo" id='<?php echo $idAlumno; ?>' class="codigo" value='<?php echo $Codigo; ?>'>
            <span><?php echo $i.'. '.$Nombre.' '.$Apellido;?><span>
          </div>
          <div class="userButtons">
            <button id="<?php echo $idAlumno; ?>" class="edit"><i class="fas fa-pencil-alt"></i></button>
            <button id="<?php echo $idAlumno; ?>" class="delete"><i class="fas fa-trash"></i></button>
          </div>
        </div>
      <?php } ?>
    </div>
  </main> 
  <div class="delete-back">
    <div class="delete__container-delete">
      <form action="" method="post">
        <div class="container-delete__title">
          <h3>¿Estas seguro que quieres eliminar al alumno de la lista?</h3>
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
            include('../editTable/deleteStudent.php');
          }
        ?>
      </form>
    </div>
  </div>
  <div class="modify-table-back">
    <div class="modify__container-modify">
      <form action="" method="post" autocomplete="off">
        <div class="container-modify__title">
          <h3 id="modifyTitle">Edicion rapida de la informacion del estudiante</h3>
        </div>
        <div class="container-modify__name">
          <label for="nombreUsuario">Nombre</label>
          <input type="text" name="userModifyFN" id="userModifyInfo" value="<?php if(isset($_POST['userModifyFN'])){ echo $userModifyFN; }?>">
          <input type="hidden" name="idUser" id="idUser" value="<?php if(isset($_POST['idUser'])){ echo $idStudent; }?>">
        </div>
        <div class="container-modify__apellido">
          <label for="apellidoUsuario">Apellido</label>
          <input type="text" name="userModifyLN" id="userModifyInfo" value="<?php if(isset($_POST['userModifyLN'])){ echo $userModifyLN; }?>">
        </div>
        <div class="container-modify__codigo">
          <label for="codigoUsuario">Codigo</label>
          <input type="text" name="userModifyCode" id="userModifyInfo" value="<?php if(isset($_POST['userModifyCode'])){ echo $userModifyCode; }?>">
        </div>
        <div class="container-modify__buttons">
          <input type="submit" id="aceptarModify" value="Aceptar" name="aceptar">
          <input type="button" id="cancelarModify" value="Cancelar">
        </div>
        <?php
          if(isset($_POST['aceptar'])){
            if(empty($_POST['userModifyFN']) || empty($_POST['userModifyLN']) || empty($_POST['userModifyCode'])){
              echo '<script>swal("No puedes dejar ningun campo vacio", "", "warning")</script>';
            } else{
              include('../editTable/editStudent.php');
            }
          }
        ?>
      </form>
    </div>
  </div>
  <div class="add-user-back active">
    <div class="add__container-add">
      <form action="" method="post" autocomplete="off">
        <div class="container-add__title">
          <h3>Registrar nuevo estudiante</h3>
        </div>
        <div class="container-add__name">
          <label for="studentName">Nombre</label>
          <input type="text" name="studentName" id="studentName" class="inputAdd" value="<?php if(isset($studentName)){ echo $studentName; }?>">
        </div>
        <div class="container-add__apellido">
          <label for="studentLN">Apellido</label>
          <input type="text" name="studentLN" id="studentLN" class="inputAdd" value="<?php if(isset($studentLN)){ echo $studentLN; }?>"> 
        </div>
        <div class="container-add__email">
          <label for="studentEmail">Nombre del correo</label>
          <div class="email-input">
            <input type="text" name="studentEmail" id="studentEmail" class="inputAdd" maxlength="20" value="<?php if(isset($studentEmail)){ echo $studentEmail; }?>">
            <span>.cbp.stt.ap</span>
          </div>
        </div>
        <div class="container-add__password">
          <label for="studentPassword">Contraseña</label>
          <input type="text" name="studentPassword" id="studentPassword" class="inputAdd" value="<?php if(isset($studentPassword)){ echo $studentPassword; }?>">
        </div>
        <div class="container-add__code">
          <label for="studentCode">Codigo</label>
          <input type="text" name="studentCode" id="studentCode" class="inputAdd" value="<?php if(isset($studentCode)){ echo $studentCode; }?>">
        </div>
        <div class="container-add__buttons">
          <input type="submit" value="Aceptar" name="aceptarAdd" id="aceptarAdd">
          <input type="button" value="Cancelar" id="cancelarAdd">
        </div>
          <?php 
            if(isset($_POST['aceptarAdd'])){
              if(empty($_POST['studentName']) || empty($_POST['studentLN']) || empty($_POST['studentEmail']) || empty($_POST['studentPassword']) || empty($_POST['studentCode'])){
                echo '<script>swal("No puedes dejar ningun campo vacio", "", "warning")</script>';
              } else{
                include('../editTable/addStudent.php');
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