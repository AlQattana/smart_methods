<?php
require_once 'config.php';

for ($i=0; $i < 6; $i++) { 
  $m = $i + 1;
  $motor_id = 'motor' . $m;
  $motor_id = $_POST[$motor_id];
  $sql = "UPDATE motors SET `value` = '$motor_id' WHERE `id` = '$m'";

  if ($conn->query($sql) !== TRUE)
    echo "Error updating record: " . $conn->error;

}

if (isset($_POST['checkbox'])) {
  $sql = "UPDATE motors SET `value` = '1' WHERE `id` = '7'";
} else {
  $sql = "UPDATE motors SET `value` = '0' WHERE `id` = '7'";
}

if ($conn->query($sql) !== TRUE)
  echo "Error updating record: " . $conn->error;


session_start();
$_SESSION['success_message'] = "motors values were saved successfully.";
header("Location: motors.php");
exit();

mysqli_close($conn);
?>