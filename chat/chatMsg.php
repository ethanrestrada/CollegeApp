<?php

$idChat = $_POST['idChat'];
require('../conexion/conexionDB.php');

$query = "";
$chat = "";
if($idChat > 1000 && $idChat < 3000 ){
  $query .= "SELECT nombre, apellido FROM coordinadores WHERE id = $idChat";
}elseif($idChat > 3000 && $idChat < 5000){
  $query .= "SELECT nombre, apellido FROM maestros WHERE id = $idChat";
}elseif($idChat > 5000){
  $query .= "SELECT nombre, apellido FROM alumnos WHERE id = $idChat";
}

$user = mysqli_query($mysqli, $query);
while($row=mysqli_fetch_array($user)){
  $nombre = $row['nombre'].' '.$row['apellido'];
}
$chat .= '<div class="name-user-chat">
            <div class="chat__img">
              <img src="../img/user.png">
            </div>
            <h4>'.$nombre.'</h4>
          </div>
          <div class ="chat-msgs" id="chat">
            <div class="chat-box-msg"></div>
          </div>
          <div class="chat-send-msg">
            <div class="write-msg">
              <form action="" method="post" autocomplete="off" id="formMsg">
                <input type="hidden" id="incoming" name="incoming">
                <input type="text" name="msg" id="chatMsg" placeholder="Escribe tu mensaje" maxlength="1275">
                <button id="sendMsg"><i class="fas fa-paper-plane"></i></button>
              </form>
            </div>
          </div>';
echo $chat;