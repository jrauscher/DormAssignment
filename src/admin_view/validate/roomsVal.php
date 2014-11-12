<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$building = mysqli_real_escape_string($dbconn, $_POST['build']);
$floors = mysqli_real_escape_string($dbconn, $_POST['floors']);
$rooms = mysqli_real_escape_string($dbconn, $_POST['rooms']);
$valid = 1;
$error = "";
$num_rooms = 0;
$num_ra = 0;
$num_hc = 0;
$badChars = array("'","\"","for key PRIMARY");
$lets = array("A","B","C","D");

$sqlTop = "INSERT INTO `rooms`(`room_num`, `build_id`, `group_id`, `num_students`, `floor`, `gender`, `smoking`, `RA_Room`, `HC_Room`) VALUES";
$rmErr = "DELETE FROM `errors`";
$sqlRoomLet = "INSERT INTO `room_letter` (`room_num`,`build_id`,`student_id`,`letter`)VALUES";
$result3 = mysqli_query($dbconn, $rmErr) or $valid = 1;

for($i=1;$i<$floors+1;$i++){		
	for($j=1;$j<$rooms+1;$j++){
		$roomNum = $i * 100 + $j;
		$raNum = $i * 10 + $j;
		$hcNum = $i * 1000 + $j;
		
		$RA = mysqli_real_escape_string($dbconn, $_POST['RA'.$raNum.'']);
		$HC = mysqli_real_escape_string($dbconn, $_POST['HC'.$hcNum.'']);
		$curRoom = mysqli_real_escape_string($dbconn, $_POST['room_num'.$roomNum.'']);
		
		if($RA == 1){	
			$num_ra ++;
		}
		if($HC == 1){	
			$num_hc ++;
		}

		if( isset($curRoom) && $curRoom != null && $curRoom != '' && is_numeric($curRoom)){
			if($curRoom != 0){
				$sqlBot = "($curRoom,$building,0,0,$i,0,0,$RA,$HC)";
				$sql = "$sqlTop$sqlBot";
				$result = mysqli_query($dbconn, $sql) or $error = ('Error ' . mysqli_error($dbconn));
				$num_rooms ++;

				for($k=0;$k<count($lets);$k++){
					$sqlbot2 = "($curRoom,$building,0,'$lets[$k]')";
					$sqlFRL = "$sqlRoomLet$sqlbot2";
					$result4 = mysqli_query($dbconn, $sqlFRL) or $error2 = ('Error ' . mysqli_error($dbconn));
				}
		
				if( isset($error) && $error != null && $error != ''){
					$valid = 2;
					$nErr = str_replace($badChars,"",$error);
			
					$sqlErr ="INSERT INTO `errors`(`error_id`, `type`) VALUES ('DEFAULT','$nErr')";
					$result2 = mysqli_query($dbconn, $sqlErr) or die('Error ' . mysqli_error($dbconn));
				}
			}
		}
	}
}

$upBuild =  "UPDATE `building` SET `num_rooms`='$num_rooms',`floor`='$floors',`RA_rooms`='$num_ra',`handicapped_rooms`='$num_hc' WHERE build_id ='$building'";
$upResult = mysqli_query($dbconn, $upBuild) or die('Error ' . mysqli_error($dbconn));

if ($valid == 1){
print<<<END
<script>
window.location="../settings.php?validate=Rooms added sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Rooms not added, duplicate entry!&error=1";
</script>
END;
}
?>









 
