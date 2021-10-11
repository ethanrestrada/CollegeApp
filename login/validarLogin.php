<?php 
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(isset($_POST['submit'])){
    if(str_contains($email, 'cr.admin') || str_contains($email, 'tc.mt') ||  str_contains($email, 'stt.ap')){
      include('./login/conexionLogin.php');
    }elseif(empty($email) || empty($password)){
      echo '<script> swal("¡Vuelve a intentarlo!", "Rellena todos los campos esta vez.", "warning"); </script>';
    }else{
      echo '<script> swal("¡No pudimos encontrarte!", "Revisa si ingresaste los datos correctamente.", "error"); </script>';
    } 
  } 
?> 