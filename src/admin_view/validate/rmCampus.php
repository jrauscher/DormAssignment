<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$campus = mysqli_real_escape_string($dbconn, $_POST['campus']);

$valid = 1;

$getID = "SELECT build_id From building WHERE campus='$campus'";
$IDS = mysqli_query($dbconn, $getID) or ($valid=2);

while( $row = mysqli_fetch_assoc($IDS) ){
	foreach($row as $val){
		$sql2="DELETE FROM room_letter WHERE build_id='$val'";
		$sql3="DELETE FROM rooms WHERE build_id='$val'";
		$result2 = mysqli_query($dbconn, $sql2) or ($valid=2);
		$result3 = mysqli_query($dbconn, $sql3) or ($valid=2);
	}
}	

$sql="DELETE FROM building WHERE campus='$campus'";
$result = mysqli_query($dbconn, $sql) or ($valid=2);

if($valid = 1){
print<<<END
<script>
window.location="../settings.php?validate=Campus sucessfully removed!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Campus could not be removed!";
</script>
END;
}
?> 
