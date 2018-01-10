<?php
  try{
    $conn = new PDO('mysql:host=localhost;dbname=db_enak2', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(Exception $e){
    echo "You have problem with your connection : ".$e->getMessage()."<br>";
    die();
  }
?>
