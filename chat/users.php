<?php

while($row=mysqli_fetch_array($busqueda)){
  $name = $row['nombre'].' '.$row['apellido'];
  (strlen($name) > 28 ) ? $username = substr($name, 0 , 28).'...'  : $username = $name;

  $users .= '<div class="user-chat" id="'.$row['id'].'">
              <div class="chat__img">
                <img src="../img/user.png" alt="Perfil">
              </div>
              <div class="chat__name-msg">
                <h4>'.$username.'</h4>
              </div>
            </div>';
}