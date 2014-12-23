<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$bID = mysqli_real_escape_string($dbconn, $_POST['build']); /**< Gets the building ID from the settings.php?page=rRooms page. */
$room_num = mysqli_real_escape_string($dbconn, $_POST['rNum']); /**< Gets the room number from the settings.php?page=rRooms page. */
$valid = 1; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql1="DELETE FROM room_letter WHERE build_id='$bID'"; /**< SQL string that deletes the room_letter where the build_id = $bID. */
$sql2="DELETE FROM rooms WHERE build_id='$bID' AND room_num='$room_num' "; /** SQL string that deletes the rooms where the build_id = $bID and room_num = $room_num. */

if( isset($room_num) && $room_num != null && $room_num != '' && is_numeric($room_num) ){
        $valid ++;
}
if($valid == 1){
	$result = mysqli_query($dbconn, $sql1) or $error = ('Error ' . mysqli_error($dbconn));
	$result2 = mysqli_query($dbconn, $sql2) or $error = ('Error ' . mysqli_error($dbconn));
}

if($valid == 1){
print<<<END
<script>
window.location="../settings.php?validate=Rooms sucessfully removed!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Rooms could not be removed!";
</script>
END;
}
?> 
