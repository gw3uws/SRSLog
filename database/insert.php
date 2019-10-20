<?php
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
include 'connect.php';


$timestamp = $_POST['qso_time'];
$datestamp = $_POST['qso_date'];
$callsign = strtoupper($_POST['callsign']);
$band = strtoupper($_POST['band']);
$mode =  strtoupper($_POST['mode']);
$freq =  $_POST['Freq'];
$rst_sent =  $_POST['RST_Sent'];
$rst_rcvd =  $_POST['RST_RCVD'];
$comments =  strtoupper($_POST['Notes']);

//SQL Insert Statement
$sql = "INSERT INTO `eventname` (`LogID`, `Call`, `QSO_Date`, `Time_On`, `Band`, `Mode`, `Freq`, `RST_Sent`, `RST_Rcvd`, `Notes`)
        VALUES(NULL, '".$callsign."', '" . $datestamp . "','" . $timestamp ."','".$band."','".$mode."','".$freq."','".$rst_sent."','".$rst_rcvd."','".$comments."')";

//SQL Query / Error handler
if (mysqli_query($con, $sql)) {
    echo '<div class="alert alert-success alert-dismissable" id="flash-msg"><h4><p>Log Recorded<p></h4></div>';
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

echo '<script type = "text/javascript">
$(document).ready(function () {
    $("#flash-msg").delay(500).fadeOut("slow");
});
</script>';

?>
