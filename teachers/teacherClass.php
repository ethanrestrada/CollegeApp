<?php
  if(isset($_POST["asignar"])){
    require('../conexion/conexionDB.php');
    $workName = mysqli_real_escape_string($mysqli, $_POST['workName']);
    $workAbout = mysqli_real_escape_string($mysqli, $_POST['workAbout']);
    $workDueTo = date("Y-m-d", strtotime($_POST['workDueto']));
  }
  if(isset($_POST['edit'])){
    require('../conexion/conexionDB.php');
    $editName = mysqli_real_escape_string($mysqli, $_POST['editName']);
    $editAbout = mysqli_real_escape_string($mysqli, $_POST['editAbout']);
    $editDueTo = date("Y-m-d", strtotime($_POST['editDueto']));
    $idWork = $_POST['idWork'];
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="shortcut icon" href="../img/faviconhome.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/teacherClass.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <title>Inicio | Clases</title>
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
      $query = mysqli_query($mysqli, "SELECT grado, seccion, catedra FROM clase 
                                      JOIN grados ON clase.id_grado = grados.id 
                                      JOIN catedras ON clase.id_catedra = catedras.id 
                                      WHERE clase.id = $clase");
      while($fila=mysqli_fetch_array($query)){
        echo $fila['catedra'].'<br>';
        echo $fila['grado'].' '.$fila['seccion'];
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
        <a href="./teacherClass.php?clase=<?php echo $clase; ?>&grado=<?php echo $grado ?>">
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
    <div class="main__add">
      <div class="add__text">
        <h3>Agregar Tarea</h3>
      </div>
      <div class="add__icon">
        <i class="fas fa-plus"></i>
      </div>
    </div>
    <div class="main__title">
      <h1>Actividades Programadas</h1>
    </div>
    <div class="main__activities">
      <?php 
        require('../conexion/conexionDB.php');
        $query = mysqli_query($mysqli, "SELECT * FROM tareas WHERE id_clase = $clase ORDER BY id DESC");
          if(mysqli_num_rows($query) > 0){
            while($row=mysqli_fetch_array($query)){
            ($row['tipo'] == "Aviso") ? $icon = '<i class="fas fa-info-circle"></i>' : $icon = '<i class="far fa-clipboard"></i>';
            ($row['updated_at'] != "null") ? $modified = '<strong>Modificada: </strong>'.$row['updated_at'] : $modified = '';
        ?>
        <div class="activities__activity">
          <div class="activity__type" id=<?php echo $row['tipo']; ?>>
            <h3><?php echo $icon; ?></h3>
          </div>
          <div class="activity__teacher">
            <h3><?php echo $userName; ?></h3>
          </div>
          <div class="activity__date">
            <h5><?php echo $row["created_at"]; ?></h5>
          </div>
          <div class="activity__about">
            <h4><?php echo $row["titulo"]; ?></h4>
            <input type="hidden" id="<?php echo $row["id"];?>" name="workInfo" class="workTitle" value="<?php echo $row["titulo"] ?>">
            <input type="hidden" id="<?php echo $row["id"];?>" value="<?php echo $row["id"] ?>">
            <p>
              <?php echo $row["descripcion"]; ?>
              <?php $entrega = date("d-m-Y", strtotime($row['entrega'])) ?>
              <br><strong>Entrega:</strong> <?php echo $entrega; ?>
              <br><span><?php echo $modified; ?></span>
              <input type="hidden" id="<?php echo $row["id"];?>" name="workInfo" class="workAbout" value="<?php echo $row["descripcion"]; ?>">
              <input type="hidden" id="<?php echo $row["id"];?>" name="workInfo" class="workFile" value="<?php echo $row["name_file"]; ?>">
              <input type="hidden" id="<?php echo $row["id"];?>" name="workInfo" class="workDueTo" value="<?php echo $row["entrega"]; ?>">
            </p>
          </div>
          <?php 
            if($row["code_file"] != "null"){
              echo '<a class="activity_file" href="../homework/workfiles/grado_'.$grado.'/'.$row["code_file"].'" download="cbp_'.$row["name_file"].'">';
              echo '<span><i class="fas fa-file"></i>'.$row["name_file"].'</span>';
              echo '<span><i class="fas fa-download"></i></span>';
              echo '</a>';
            }
          ?>
          <div class="activity__modify">
            <div class="activity__edit editActivity" id="<?php echo $row["id"]; ?>">
              <i class="fas fa-pencil-alt"></i>
            </div>
            <div class="activity__drop dropActivity" id="<?php echo $row["id"]; ?>">
              <i class="fas fa-trash"></i>
            </div>
          </div>
        </div>
        <?php 
          } }
          else{
            echo "<h1 class='workStatus'>¡Sin actividades programadas!</h1>";
          }
        ?>
      </div>
    </div>
  </main>
  <!-- Asignar -->
  <div class="add-activity-back" id="content">
    <div class="container-activity-add">
      <h3>Asigna una tarea</h3>
      <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="activity-add__title">
          <label for="workName">Tema</label>
          <input type="text" name="workName" id="workName" maxlength="255" value="<?php if(isset($workName)) echo $workName; ?>">
        </div>
        <div class="activity-add__about">
          <label for="workAbout">Especificaciones</label>
          <textarea name="workAbout" id="workAbout" maxlength="1275" rows="4"><?php if(isset($workAbout)) echo $workAbout; ?></textarea>
        </div>
        <div class="activity-add__due-type">
          <div class="activity__due-to">
            <label for="workDueto">Fecha de entrega</label>
            <input type="date" name="workDueto" min="2021-01-01" id="workDueto" value="<?php if(isset($workDueTo)) echo $workDueTo; ?>">
          </div>
          <div class="activity__type-work">
            <label for="workDueto">Tipo de asignacion</label>
            <select name="workTipo" id="workTipo">
              <option value="Aviso">Aviso</option>
              <option value="Tarea">Tarea</option>
            </select>
          </div>
        </div>
        <div class="activity-add__file">
          <label for="workFile"><i class="fas fa-file"></i>Subir archivo</label>
          <input type="file" name="workFile" id="workFile"><br>
          <span id="nameFile"></span>
        </div>
        <div class="activity-add__buttons">
          <input type="submit" value="Asignar" id="asignar" name="asignar">
          <input type="button" value="Cancelar" id="cancelar">
        </div> 
        <?php 
          if(isset($_POST['asignar'])){
            if(empty($_POST['workName']) || empty($_POST['workAbout']) || empty($workDueTo)){
              echo '<script> swal("Llena todos los datos", "", "warning"); </script>';
            } else{
              include("../homework/insertWork.php");
            }
          }
        ?>
      </form>
    </div>
  </div>
  <!-- Modificar -->
  <div class="edit-homework-back">
    <div class="container-activity-add">
      <h3>Modificar tarea</h3>
      <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="activity-add__title">
          <label for="">Tema</label>
          <input type="text" name="editName" id="editWorkInfo" value="<?php if(isset($_POST['editName'])){ echo $editName; }?>">
          <input type="hidden" name="idWork" id="idWork" value="<?php if(isset($_POST['idWork'])){ echo $idWork; }?>">        
        </div>
        <div class="activity-add__about">
          <label for="">Especificaciones</label>
          <textarea name="editAbout" id="editWorkInfo" maxlength="1275" rows="4" ><?php if(isset($_POST['editAbout'])){ echo $editAbout; }?></textarea>
        </div>
        <div class="activity-add__due-type">
          <div class="activity__due-to">
            <label for="editWorkInfo">Fecha de entrega</label>
            <input type="date" name="editDueto" min="2021-01-01" id="editWorkInfo" value="<?php if(isset($workDueTo)) echo $workDueTo; ?>">
          </div>
          <div class="activity__type-work">
            <label for="workDueto">Tipo de asignacion</label>
            <select name="editTipo" id="workTipo">
              <option value="Aviso">Aviso</option>
              <option value="Tarea">Tarea</option>
            </select>
          </div>
        </div>
        <div class="activity-add__file">
          <label for="editWorkFile"><i class="fas fa-file"></i>Subir archivo</label>
          <input type="file" name="editFile" id="editWorkFile"><br>
          <span id="editNameFile"></span>
          <input type="hidden" name="archivo" id="archivo">        
        </div>
        <div class="activity-add__buttons">
          <input type="submit" value="Asignar" id="asignar" name="edit">
          <input type="button" value="Cancelar" id="cancelar" onclick="cancelEdit()">
        </div>
        <?php 
          if(isset($_POST["edit"])){
            if(empty($_POST['editName']) || empty($_POST['editAbout'])){
              echo '<script>swal("No puedes dejar una tarea sin especificacion o tema", "", "warning")</script>';
            } else {
              include("../homework/updateWork.php");
            }
          }
        ?>
      </form>
    </div>
  </div>
  <!-- Eliminar -->
  <div class="delete-homework-back">
    <div class="container-activity-delete">
      <h3>¿Estas seguro que deseas eliminar la actividad?</h3>
        <div class="activity-delete__buttons">
          <form action="" method="post">
            <input type="submit" value="Aceptar" name="delete" id="delete">
            <input type="button" value="Cancelar" id="cancelar" onclick="cancelDelete()">
            <input type="hidden" name="idWorkDelete" id="idWorkDelete">
              <?php
                if(isset($_POST['delete'])){
                  include('../homework/deleteWork.php');
                }
              ?>
          </form>
        </div>
    </div>
  </div>
  <script src="../js/sidemenu.js"></script>
  <script src="../js/teacherActivity.js"></script>
  <script src="../js/closeSession.js"></script>
</body>
</html>