<?php
	include ('../../../includes/svrConnect.php');

// escape variables for security
$values = mysqli_real_escape_string($dbconn, $_POST['num_rooms']); /**< Gets the number of rooms from the settings.php?page=eRooms page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */
$valid2 = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */
$temp = explode(":",$values); /**< array that has all the values in $values that were seperated by ':' */
$num_rooms = $temp[0]; /**< Total number of rooms. */
$BID = $temp[1]; /**< Building id. */
$num_ra = 0; /**< Number of RA Rooms. */
$num_hc = 0; /**< Number of Handicapped Rooms. */

for($i=0;$i<$num_rooms;$i++){		
	$room = mysqli_real_escape_string($dbconn, $_POST['room'.$i.'']);
	$oldRoom = mysqli_real_escape_string($dbconn, $_POST['oldRoom'.$i.'']);
	$floor = mysqli_real_escape_string($dbconn, $_POST['floor'.$i.'']);
	$oldFloor = mysqli_real_escape_string($dbconn, $_POST['oldFloor'.$i.'']);
	$RA = mysqli_real_escape_string($dbconn, $_POST['RA'.$i.'']);
	$HC = mysqli_real_escape_string($dbconn, $_POST['HC'.$i.'']);

	$sql = "UPDATE `rooms` SET `room_num`=$room,`floor`=$floor,`RA_Room`=$RA,`HC_Room`=$HC WHERE build_id ='$BID' AND room_num='$oldRoom'";

	if( isset($room) && $room != null && $room != '' && is_numeric($room) ){
        $valid ++;
	}

	if( isset($floor) && $floor != null && $floor != '' && is_numeric($floor)){
        $valid ++;
	}

	if($RA == 1){
		$num_ra ++;
	}
	if($HC == 1){
		$num_hc ++;
	}

	if ($valid == 2){
		$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));
		$valid = 0;
		$valid2 ++;
	}

}

if ($valid2 == $num_rooms){

	$upBuild =  "UPDATE `building` SET `RA_rooms`='$num_ra',`handicapped_rooms`='$num_hc' WHERE build_id ='$BID'";

	$upResult = mysqli_query($dbconn, $upBuild) or die('Error ' . mysqli_error($dbconn));

print<<<END
<script>
window.location="../../settings.php?validate=Rooms updated sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../../settings.php?validate=ERROR: Rooms were not updated, invalid input!";
</script>
END;
}
?> 
