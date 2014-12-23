<?php
/**
* <pre>
* CHECK_ROOM: Makes sure students are of the correct lease type, gender, and that the room is not full.
* TAKES: Student ID, Room Number, and Building ID.
* RETURNS: 0 if the student cannot go into that room.
* 	  1 if the student can be placed into that room.
*</pre>
*/
function check_room ($std_id,$room_num,$build_id){
	include ('../includes/svrConnect.php');
	$student_info = "SELECT gender, lease FROM students WHERE student_id='$std_id'";
	$room_info = "SELECT gender, num_students FROM rooms WHERE room_num='$room_num' AND build_id='$build_id'";
	$build_info = "SELECT lease FROM building WHERE build_id='$build_id'";
	$std_info = mysqli_query($dbconn, $student_info);
	$r_info = mysqli_query($dbconn, $room_info);
	$b_info = mysqli_query($dbconn, $build_info);

	$sGender ="";
	$sLease = "";
	$rLease = "";
	$rGender = "";
	$rFull = "";

	while ($row = mysqli_fetch_array($std_info)) {
		$sGender = $row['gender'];
		$sLease = $row['lease'];
	}
	while ($row = mysqli_fetch_array($r_info)) {
		$rGender = $row['gender'];
		$rFull = $row['num_students'];
	}
	while ($row = mysqli_fetch_array($b_info)) {
		$rLease = $row['lease'];
	}

	if(($sGender == $rGender)&&($sLease == $rLease)&&($rFull != 4)){
		return 1;
	}
	if(($rFull == 0)&&($sLease == $rLease)){
		$up_room_gen = "UPDATE `rooms` SET `gender`='$sGender' WHERE room_num='$room_num' AND build_id='$build_id'";
		$up_room_gen2 = mysqli_query($dbconn, $up_room_gen);
		return 1;
	}
	else{
		return 0;
	}
}
?>
