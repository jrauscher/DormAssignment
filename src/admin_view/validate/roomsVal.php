<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$building = mysqli_real_escape_string($dbconn, $_POST['build']); /**< Gets the building ID from the settings.php?page=14 page. */
$floors = mysqli_real_escape_string($dbconn, $_POST['floors']); /**< Gets the number of floors from the settings.php?page=14 page. */
$rooms = mysqli_real_escape_string($dbconn, $_POST['rooms']); /**< Gets the number of rooms from the settings.php?page=14 page. */
$valid = 1; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */
$error = ""; /**< Stores the all errors that can occur while adding rooms to a building. */
$num_rooms = 0; /**< The number of rooms. */
$num_ra = 0; /**< The number of RA rooms. */
$num_hc = 0; /**< the number of HC rooms. */
$badChars = array("'","\"","for key PRIMARY"); /**< Characters that we don't want present in the error messages. */
$lets = array("A","B","C","D"); /**< Possible room letters */

$sqlTop = "INSERT INTO `rooms`(`room_num`, `build_id`, `group_id`, `num_students`, `floor`, `gender`, `smoking`, `RA_Room`, `HC_Room`) VALUES"; /**< SQL string that adds a new room into the rooms table, part 1. */
$rmErr = "DELETE FROM `errors`"; /**< SQL string that removes all errors from the errors table (errors from previous run are stores there). */
$sqlRoomLet = "INSERT INTO `room_letter` (`room_num`,`build_id`,`student_id`,`letter`)VALUES"; /**< SQL string that adds a new room into the rooms table, part 2. */
$result3 = mysqli_query($dbconn, $rmErr) or $valid = 1; /**< Runs the SQL Query in $rmErr. */ 

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

$upBuild =  "UPDATE `building` SET `num_rooms`='$num_rooms',`floor`='$floors',`RA_rooms`='$num_ra',`handicapped_rooms`='$num_hc' WHERE build_id ='$building'"; /**< $SQL string that updates the building with the new room infromation. */
$upResult = mysqli_query($dbconn, $upBuild) or die('Error ' . mysqli_error($dbconn)); /**< Runs the SQL Query $upBuild. */

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









 
