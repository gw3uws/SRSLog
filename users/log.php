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

//Get time in HHMM 24hour UTC format
$timestamp = gmdate("Hi");
//Get date in YYYYMMDD format
$datestamp = date('Ymd');

echo "<div class='newlog' id='newlog'><form action='../database/insert.php' method='post' id='myform' class='myform' name='myform'>
    <text>Callsign: </text><input type='text' name='callsign' id='callsign' class='callsign' maxlength='12' style='text-transform:uppercase' required>
    <text>Band:     </text><select name='band'>
    <option value='70cm'>70cm</option>
    <option value='2m'>2m</option>
    <option value='6m'>6m</option>
    <option value='10m'>10m</option>
    <option value='12m'>12m</option>
    <option value='15m'>15m</option>
    <option value='17m'>17m</option>
    <option value='20m'>20m</option>
    <option value='30m'>30m</option>
    <option value='40m'>40m</option>
    <option value='80m'>80m</option>
    <option value='160m'>160m</option>
    </select>
    <text>Mode:     </text><select name='mode'>
    <option value='SSB'>SSB</option>
    <option value='FM'>FM</option>
    <option value='CW'>CW</option>
    <option value='PKT'>Packet</option>
    </select>
    <text>QSO Date: </text><input type='text' name='qso_date' value='".$datestamp."' size='5' required>
    <text>QSO Time: </text><input type='text' name='qso_time' id='qso_time' value='".$timestamp."' maxlength='4' size='2' required>
    <br>
    <text>Frequency (MHz): </text><input type='text' name='Freq' style='width: 150px' required>
    <text>RST Sent: </text><input type='number' name='RST_Sent' max='599' style='width: 75px' required>
    <text>RST Received: </text><input type='number' name='RST_RCVD' max='599' style='width: 75px' required>
    <text>Comments: </text><input type='text' name='Notes' maxlength='34' size='29'>
    <button class='insert' hidden='true'>Submit</button>
    <p class='result'></p>
    </form></div><br>
    
    <script type = 'text/javascript'>
    $('.myform').submit(function(e) {
    
    //Submitting data to insert.php
    var data = $(this).serialize();
    var url = $(this).attr('action');
    var resultDiv = $(this).find('.result');
    
    //Resetting the form
    timestamp = (new Date).toTimeString().slice(0,5);
    timestamp = timestamp.slice(0,2) + timestamp.slice(3);
    document.getElementById('qso_time').value = timestamp;
    document.getElementById('callsign').value = '';
    document.getElementById('callsign').focus();
    
    $.post(url, data, function(result) {
    //Inserts result string into p tags
    resultDiv.html(result);
    });
    return false;
    });
    
    </script>";
    
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