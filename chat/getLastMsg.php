<?php

  while($row=mysqli_fetch_array($users)){
    $incoming = $row['id'];
    $query2 = "SELECT * FROM chat WHERE (chat.incoming_id = $idUser OR chat.outgoing_id = $idUser)
              AND (chat.incoming_id = $incoming OR chat.outgoing_id = $incoming) ORDER BY chat.id DESC LIMIT 1";
    $result = mysqli_query($mysqli, $query2);
    while($row2=mysqli_fetch_array($result)){
      $name = $row['nombre'].' '.$row['apellido'];
      (strlen($name) > 26 ) ? $username = substr($name, 0 , 26).'...'  : $username = $name;
      (strlen($row2['msg']) > 18) ? $msg = substr($row2['msg'], 0, 18).'...' : $msg = $row2['msg'];
      if(isset($row2['outgoing_id'])){
        ($row2['outgoing_id'] == $idUser) ? $you = 'Tu: ' : $you = '';
      }else{
        $you = '';
      }  
      $chat = '<div class="user-chat chat" id="'.$row['id'].'">
                <div class="chat__img">
                  <img src="../img/user.png" alt="Perfil">
                </div>
                <div class="chat__name-msg">
                  <h4>'.$username.'</h4>
                  <span>'.$you.' '.$msg.'</span>
                </div>
              </div>';
            }
    echo $chat;
  }