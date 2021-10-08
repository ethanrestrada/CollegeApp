<?php 
  $urlAdm = "admins/adminsIndex.php";
  $urlTeacher = "teachers/teachersIndex.php";
  $urlStudent = "students/studentsIndex.php";

  require('./conexion/conexionDB.php');

  if(str_contains($email, 'cr.admin')){
    $query = "SELECT id, correo, nombre, apellido, id_rol FROM coordinadores WHERE correo ='$email' AND contrasenia ='$password' AND estado='activo'";
  } else if(str_contains($email, 'tc.mt')){
    $query = "SELECT id, correo, nombre, apellido, id_rol FROM maestros WHERE correo ='$email' AND contrasenia ='$password' AND estado='activo'";
  } else if (str_contains($email, 'stt.ap')){
    $query = "SELECT id, correo, nombre, apellido, id_rol FROM alumnos WHERE correo ='$email' AND contrasenia ='$password' AND estado='activo'";
  }

  $searchUser = mysqli_query($mysqli,$query);
  if($searchUser){
  $findUser = mysqli_num_rows($searchUser);
  while($row=mysqli_fetch_array($searchUser)){
    $id = $row["id"];
    $rol = $row["id_rol"];
    $nombre = $row['nombre'].' '.$row['apellido'];
  }

  if($findUser > 0 ){
    session_start();
    $_SESSION['userEmail'] = $email;
    $_SESSION['userID'] = $id;
    $_SESSION['userName'] = $nombre;
    if($rol == 1){
      header('location: '.$urlAdm.'');
      $_SESSION['url'] = $urlAdm;
    } elseif($rol == 2){
      header('location: '.$urlTeacher.'');
      $_SESSION['url'] = $urlTeacher;
    } elseif($rol == 3){
      header('location: '.$urlStudent.'');      
      $_SESSION['url'] = $urlStudent;
    }

  } else if($findUser == 0) {
    echo '<script> swal("¡No pudimos encontrarte!", "Revisa si ingresaste los datos correctamente.", "error"); </script>';
  }}else{
    echo $mysqli->error;
  }
?>