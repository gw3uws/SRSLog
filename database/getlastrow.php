<?php
include 'connect.php';

$sql="SELECT `Call`,`Mode`,`Freq` FROM eventname ORDER BY LogID DESC LIMIT 1";
if ($result=mysqli_query($con,$sql)){
  $output = $result->fetch_row();
  }else{ printf("Failed to get row"); }
echo json_encode($output);
?>
