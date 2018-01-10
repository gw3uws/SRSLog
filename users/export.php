<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}


include('../database/connect.php');

//Fetch event details from database
if ($result=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM event WHERE 1"))){
  }else{ printf("Failed to get Event Name"); }
  $Event_name = $result['Name'];

echo '<html><head><title>SRS Log</title><link rel="stylesheet" type="text/css" href="../stylesheet.css?v=' . time() . '">';
echo '<script language="javascript" type="text/javascript" src="../jquery.js"></script>';
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
echo '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet"></head><body>';
echo '<br><br><h1>' . $Event_name . '</h1>';
echo "<br><br>";

$myfile = fopen("logbook.adi", "w") or die("Unable create ADIF file");
$txt = "SRSLog " . gmdate('Y-m-d h:i:s \G\M\T') . "<ProgramID:6>SRSLog<eoh>\n\n";
fwrite($myfile, $txt);

$sql = "SELECT * FROM yotamonth17";
if ($result=mysqli_query($con,$sql)){

 while ($row = mysqli_fetch_array($result)) 
 {
     $txt = ("<QSO_DATE:".strlen($row['QSO_Date']).">".$row['QSO_Date'].
            "<TIME_ON:".strlen($row['Time_On']).">".$row['Time_On'].
            "<FREQ:".strlen($row['Freq']).">".$row['Freq'].
 	    "<CALL:".strlen($row['Call']).">".$row['Call'].
 	    "<RST_RCVD:".strlen($row['RST_Rcvd']).">".$row['RST_Rcvd'].
 	    "<RST_SENT:".strlen($row['RST_Sent']).">".$row['RST_Sent'].
 	    "<MODE:".strlen($row['Mode']).">".$row['Mode'].
 	    "<NOTES:".strlen($row['Notes']).">".$row['Notes'].
 	    "<BAND:".strlen($row['Band']).">".$row['Band']
            ."<eor>"."\n");
     fwrite($myfile, $txt);
 }
  }else{ printf("Failed to get NumRows"); }

fclose($myfile);

echo '<form action="logbook.adi" method="post">
      <p>Export logbook in ADIF format</p><button type="submit">Export</button>
      </form>';

echo '
        <div id="navbar" class="navbar"><ul>
        <li><a href="../index.php">Frontend</a></li>
	<li><a href="log.php">New Log</a></li>
	<li><a href="register.php">Register</a></li>
	<li><a href="export.php">Export</a></li>
	<li><a href="logout.php">Logout</a></li>
	<li><a href="login.php">Login</a></li></ul></div>
	';

mysqli_close($con);
echo '</body></html>';
?>