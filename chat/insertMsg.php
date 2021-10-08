<?php

  session_start();
  require('../conexion/conexionDB.php');

  $outgoingId = $_SESSION['userID'];
  $incomingId = $_POST['incoming'];
  $msg = mysqli_real_escape_string($mysqli, $_POST['msg']);

  if(!empty($msg)){
    $query = mysqli_query($mysqli, "INSERT INTO chat(incoming_id, outgoing_id, msg) VALUES
                                    ($incomingId, $outgoingId, '$msg')");
}

