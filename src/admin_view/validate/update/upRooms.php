<?php
	include ('../../../includes/svrConnect.php');

// escape variables for security
$values = mysqli_real_escape_string($dbconn, $_POST['num_rooms']);
$valid = 0;
$valid2 = 0;
$temp = explode(":",$values);
$num_rooms = $temp[0];
$BID = $temp[1];
$num_ra = 0;
$num_hc = 0;

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
