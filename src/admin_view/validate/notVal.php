<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$wDate = mysqli_real_escape_string($dbconn, $_POST['wDate']);
$fName = mysqli_real_escape_string($dbconn, $_POST['fName']);
$dDate = mysqli_real_escape_string($dbconn, $_POST['dDate']);
$valid = 1;

if( isset($wDate) && $wDate != null && $wDate != '' ){
	$sql = "UPDATE form_settings SET warning_date='$wDate' WHERE form_name='$fName'"; 
	echo "$sql\n";
	$result = mysqli_query($dbconn, $sql) or($valid=2);
}
if( isset($dDate) && $dDate != null && $dDate != '' ){
	$sql = "UPDATE form_settings SET deadline_date='$dDate' WHERE form_name='$fName'"; 
	echo "$sql\n";
	$result = mysqli_query($dbconn, $sql) or($valid=2);
}
else{
	$valid=2;
}


if ($valid == 1){
print<<<END
<script>
window.location="../settings.php?validate=Notification dates updated sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Notification dates could not be updated, invalid input!";
</script>
END;
}
?> 
