<?php
require_once 'config.php';

if (isset($_POST['mov_value'])) {
  $mov_value = $_POST['mov_value'];
  switch ($mov_value) {
    case 'stop':
      $dir = 0;
      break;
    case 'forward':
      $dir = 1;
      break;      
    case 'right':
      $dir = 2;
      break;        
    case 'left':
      $dir = 3;
      break;  
    case 'backward':
      $dir = 4;
      break;    
  }
  $sql = "UPDATE motors SET `value` = '$dir' WHERE `id` = '8'";
}

if ($conn->query($sql) !== TRUE)
  echo "Error updating record: " . $conn->error;

mysqli_close($conn);
?>