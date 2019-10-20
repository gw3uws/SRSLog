<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}


echo '<html><head><title>SRS Log</title><link rel="stylesheet" type="text/css" href="../stylesheet.css?v=' . time() . '">';
echo '<script language="javascript" type="text/javascript" src="../jquery.js"></script>';
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
echo '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet"></head><body>';
echo "<br><br>";

echo '<h1>Welcome ' . $_SESSION['username'];
echo '<br><h2></h2>
        <div id="navbar" class="navbar"><ul>
        <li><a href="../index.php">Frontend</a></li>
	<li><a href="log.php">New Log</a></li>
	<li><a href="register.php">Register</a></li>
	<li><a href="export.php">Export</a></li>
	<li><a href="logout.php">Logout</a></li>
	<li><a href="login.php">Login</a></li></ul></div>
	';
	
echo '</body></html>';
?>