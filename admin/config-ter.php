<?php
  $hostname = "localhost";
  $username = "u679404284_petromaka";
  $password = "Petromaka265***";
  $dbname = "u679404284_petromaka";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
