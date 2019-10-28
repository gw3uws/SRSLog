<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header('location: login.php');
  exit;
}

include('../database/connect.php');

//Fetch event details from database
if ($result=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM event WHERE 1"))){
  }else{ printf('Failed to get Event Name'); }
  $Event_name = $result['Name'];

echo '<html><head><title>SRS Log</title><link rel="stylesheet" type="text/css" href="../stylesheet.css?v=' . time() . '">';
echo '<script language="javascript" type="text/javascript" src="../jquery.js"></script>';
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
echo '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet"></head><body>';
echo '<br><br><h1>' . $Event_name . '</h1>';
echo '<br><br>';

//Get time in HHMM 24hour UTC format - this might be redundant to the javascript code
//date_default_timezone_set('UTC');
//$timestamp = date('Hi'); //H: hours with leading zeros, i: seconds with leading zeros

//Get date in YYYYMMDD format
$datestamp = date('Ymd');

echo "
	<div class='newlog' id='newlog'><form action='../database/insert.php' method='post' id='myform' class='myform' name='myform'>
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
	<text>Mode:     </text><input list='mode' name='mode' type='datalist'>
	<datalist id='mode'>
	<option value='AM'>Amplitude Modulation</option>
	<option value='ARDOP'>Amateur Radio Digital Open Protocol</option>
	<option value='ATV'>Amateur Television</option>
	<option value='C4FM'>Yaesu Fusion</option>
	<option value='CHIP'>Spread-Spektrum PSK</option>
	<option value='CW'>Morse Code</option>
	<option value='DIGITALVOICE'>Digital Voice</option>
	<option value='DOMINO'>MFSK Chat</option>
	<option value='DSTAR'>ICOM D-STAR</option>
	<option value='FAX'>FAX</option>
	<option value='FM'>Frequency Modulation</option>
	<option value='FSK441'>FSK441</option>
	<option value='FT8'>FT8</option>
	<option value='HELL'>Hellschreiber </option>
	<option value='ISCAT'>Ionospheric Scattering</option>
	<option value='JT4'>JT4</option>
	<option value='JT6M'>JT6M</option>
	<option value='JT9'>JT9</option>
	<option value='JT44'>JT44</option>
	<option value='JT65'>JT65</option>
	<option value='MFSK'>Multiple Frequency Shift Keying</option>
	<option value='MSK144'>MSK144</option>
	<option value='MT63'>MT63</option>
	<option value='OLIVIA'>OLIVIA</option>
	<option value='OPERA'>OPERA</option>
	<option value='PAC'>PAC</option>
	<option value='PAX'>PAX</option>
	<option value='PKT'>Packet Radio</option>
	<option value='PSK'>Phase Shift Keying</option>
	<option value='PSK2K'>PSK2K</option>
	<option value='Q15'>Q15</option>
	<option value='QRA64'>QRA64</option>
	<option value='ROS'>ROS</option>
	<option value='RTTY'>Radio Teletype</option>
	<option value='RTTYM'>RTTYM</option>
	<option value='SSB'>Single Side Band</option>
	<option value='SSTV'>Slow Scan Television</option>
	<option value='T10'>T10</option>
	<option value='THOR'>THOR</option>
	<option value='THRB'>THRB</option>
	<option value='TOR'>TOR</option>
	<option value='V4'>V4</option>
	<option value='WINMOR'>WINMOR</option>
	<option value='WSPR'>Weak Signal Propagation Report</option>
	</datalist>

	<text>QSO Date: </text><input type='text' name='qso_date' value='".$datestamp."' size='5' required>
	<text>QSO Time: </text><input type='text' name='qso_time' id='qso_time' maxlength='4' size='2' required>
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
	document.getElementById('callsign').value = '';
	document.getElementById('callsign').focus();

	$.post(url, data, function(result) {
	//Inserts result string into p tags
	resultDiv.html(result);
	});
	return false;
	});

	</script>
";

//script to update the time every minute (bad implementation coming...)
echo "
	<script type = 'text/javascript'>
		updateTime();
		function updateTime(){
			var date = new Date;
			var time = ConvertNumberToTwoDigitString(date.getUTCHours()) + ConvertNumberToTwoDigitString(date.getUTCMinutes());
			document.getElementById('qso_time').value = time;
		}

		// Returns the given integer as a string and with 2 digits
		function ConvertNumberToTwoDigitString(n) {
    			return n > 9 ? '' + n : '0' + n;
		}

		$(function(){
  			setInterval(updateTime, 1000);
		});
	</script>
";

echo "
        <div id='navbar' class='navbar'><ul>
        <li><a href='../index.php'>Frontend</a></li>
	<li><a href='log.php'>New Log</a></li>
	<li><a href='register.php'>Register</a></li>
	<li><a href='export.php'>Export</a></li>
	<li><a href='logout.php'>Logout</a></li>
	<li><a href='login.php'>Login</a></li></ul></div>
";

mysqli_close($con);
echo '</body></html>';
?>
