<?php
include 'connect.php';
$sql="SELECT * FROM yotamonth17";
if ($result=mysqli_query($con,$sql)){
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result);
  mysqli_free_result($result);
  }else{ printf("Failed to get NumRows"); }
echo json_encode($rowcount);
?>