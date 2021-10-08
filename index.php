<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="shortcut icon" href="./img/faviconIndex.png" type="image/x-icon">
  <link rel="stylesheet" href="./css/index.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <title>Iniciar Sesion</title>
</head>
<body>
  <div class="college_name">
    <h1>Colegio Blaise Pascal</h1>
  </div>
  <div class="back">
    <div class="container__img">
      <img src="./img/user.png" alt="User">
    </div>
    <div class="container">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" autocomplete="on">
        <div class="form__input">
          <div class="input__icon">
            <i class="fas fa-user"></i>
          </div>
          <div class="input__text">
            <h5>Correo electronico</h5>
            <input type="text" name="email" id="input">
          </div>
        </div>
        <div class="form__input">
          <div class="input__icon">
            <i class="fas fa-lock"></i>
          </div>
          <div class="input__text">
            <h5>Contraseña</h5>
            <input type="password" name="password" id="input">
          </div>
        </div>
        <input type="submit" value="Conectarme" name="submit">
        <?php
          if(isset($_POST['submit']))
          {
            include('./login/validarLogin.php'); 
          }
        ?>
      </form>
    </div>
  </div>
  <script src="./js/index.js"></script>
</body>
</html>