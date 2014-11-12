<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$bName = mysqli_real_escape_string($dbconn, $_POST['bName']);
$let = mysqli_real_escape_string($dbconn, $_POST['letter']);
$valid = 1;

$getID="SELECT build_id FROM building WHERE building_name='$bName' AND building_letter='$let'";
$BID = mysqli_query($dbconn, $getID) or ($valid=2);
$ID = mysqli_fetch_assoc($BID);

$sql="DELETE FROM building WHERE building_name='$bName' AND building_letter='$let'";
$sql2="DELETE FROM room_letter WHERE build_id='$ID'";
$sql3="DELETE FROM rooms WHERE build_id='$ID'";

$result = mysqli_query($dbconn, $sql) or ($valid=2);
$result2 = mysqli_query($dbconn, $sql2) or ($valid=1);
$result3 = mysqli_query($dbconn, $sql3) or ($valid=1);

if($valid == 1){
print<<<END
<script>
window.location="../settings.php?validate=Building sucessfully removed!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Building could not be removed!";
</script>
END;
}
?> 
