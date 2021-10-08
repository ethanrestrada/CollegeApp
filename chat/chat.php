<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="shortcut icon" href="../img/chat.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/chat.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/OverlayScrollbars.min.js"></script>
  <title>Mensajes</title>
</head>
<body>
<?php 
  session_start();
  $idUser = $_SESSION['userID'];
  $url = $_SESSION['url'];
  $userName = $_SESSION['userName'];
  
  if (!isset($_SESSION['userEmail'])){
    header('location:../index.php');
  }
?>
<header>
  <a href="../<?php echo $url; ?>">
    <span><i class="fas fa-house-user"></i></span>
  </a>
  <div class="header__user-options">
    <h5><?php echo $userName; ?></h5>
    <i class="fas fa-sign-out-alt" id="closeSession"></i>
  </div>
</header>
  <div class="container-chat">
    <div class="user-chats-section">
      <div class="chat-section-container">  
        <div class="search-user-container">
          <div class="search-user">
            <input type="text" name="searchUser" id="searchUser" placeholder="Ingresa un nombre" autocomplete="off"> 
            <button><i class="fas fa-times"></i></button>
          </div>
          <div class="search-list" id="users">
            <div class="users-list" id="userslist"></div>
          </div>
        </div> 
        <input type="hidden" id="idChat">
        <input type="hidden" id="idUser" value="<?php echo $idUser; ?>">
        <div class="chats">
          <div class="chat-suggest">
            <h3>Recientes</h3>
          </div>
          <div class="new-chat">
            <label for="searchUser">
              <div class="new-chat__img">
                <img src="../img/plus.png" alt="Plus">
              </div>
              <span>Iniciar nueva conversacion</span>
            </label>
          </div>
        </div>
        <?php 
        ?>
        <div class="chat-box" id="users">
          <div class="chat__users-list" id="userslist"></div>
        </div>  
      </div>
    </div>
    <div class="chat-section-msg">
    </div>
  </div>

<script src="../js/closeSession.js"></script>
<script src="../js/chat.js"></script>
</body>
</html>