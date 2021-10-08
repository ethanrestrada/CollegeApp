<?php
  session_start();
  require('../conexion/conexionDB.php');
  $outgoingID = $_SESSION['userID'];
  $incomingID = $_POST['incoming'];

  $query = mysqli_query($mysqli, "SELECT * FROM chat WHERE (incoming_id = $incomingID AND outgoing_id = $outgoingID) 
                                  OR (incoming_id = $outgoingID AND outgoing_id = $incomingID) ORDER BY id");
  while($row=mysqli_fetch_array($query)){
    if($row['outgoing_id'] == $outgoingID){
      $msg = '<div class="outgoing-msg chat">
                <div class="msg-content">
                  <p>'.$row['msg'].'</p>
                </div>
              </div>';
    }else{
      $msg = '<div class="incoming-msg chat">
                <div class="msg-content">
                  <p>'.$row['msg'].'</p>
                </div>
              </div>';
    }
    echo $msg;
  }