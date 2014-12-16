<?php
include ('../../../includes/svrConnect.php');

echo "<style>
.center {
    position: absolute;
    width: 500px;
    height: 50px;
    top: 280px;
    left: 520px;
}
.center2 {
    position: absolute;
    width: 500px;
    height: 50px;
    top: 10px;
    left: 630px;
}
</style>
";

echo '<div class="center2"> <img src="loader.gif"></div><br/>';
echo '<div class="center">';
echo 'Note: Assigning students could take up to 5 min, you will be automatically redirected when assigning has completed...&#13;&#10&#13;&#10';
echo '<textarea id="load" style="text-align:center; width:500px; height:250px;">';
echo '-------------------- STARTING --------------------&#13;&#10';

if (ob_get_level() == 0) {
    ob_start();
}

// START ALGORITHM 
$allStudents = "SELECT * FROM students WHERE room_num=0";
$allStudentsRes = mysqli_query($dbconn, $allStudents);

$renewList = array();
$sameList = array();

$count = 0;
$std_id;
$flag = 0;
$curr_room =0;
mysqli_data_seek($allStudentsRes, 0);

// FINDS RENEWAL AND SAME ROOM REQUESTS //

echo "FINDING RENEWAL AND SAME ROOM REQUESTS...&#13;&#10";
ob_flush();
flush();

while( $row = mysqli_fetch_assoc($allStudentsRes) ){
	foreach($row as $val){
		if($count == 0){
			$std_id	= $val;
		} 
		if ($count == 4)
		{
			$curr_room =$val;
		}
		if($count == 17){
			if($val == 1){
				$flag = 1;
			}
		}
		if($count == 49 && $flag == 1){
			if($val != "" && $curr_room == $val){
				array_push($sameList,$std_id);
				$flag = 0;
			}else{
				array_push($renewList,$std_id);
				$flag = 0;
			}
		}
		$count ++;
	}
	$count = 0;
	$flag = 0;
}

echo "DONE! &#13;&#10&#13;&#10"; 
ob_flush();
flush();

// END FIND //

include ('algoFuncs.php');

// SAME ROOM: FINDS ALL STUDENTS WHO REQUESTED THE SAME ROOM AS LAST YEAR //

echo "ASSIGNING SAME ROOM STUDENTS...&#13;&#10";
ob_flush();
flush();

$room_num;
$build_id;
$leftover_table = array();
$leftover_table2 = array();
$leftover_table3 = array();

foreach ($sameList as $sl_student){
	$sl = "SELECT req_room_num, req_build_id FROM students WHERE student_id = $sl_student AND room_num=0";
	$sl_result = mysqli_query($dbconn, $sl);

	while ($row = mysqli_fetch_array($sl_result)){
		$room_num = $row['req_room_num'];
		$build_id = $row['req_build_id'];
	}
	if (check_room ($sl_student,$room_num,$build_id)== 1){
		if(assign_student ($sl_student,$build_id . $room_num,$room_num,$build_id) == 1){
		//	echo '.';
		}
		else{
			$test = in_array($sl_student,$leftover_table);
			if( $test == 1){
				echo 'ERROR: attept to re-assign student to leftover table<br/>';	
			}
			else{
				array_push($leftover_table,$sl_student);
			}
		}
	}
	else{
		$test = in_array($sl_student,$leftover_table);
		if( $test == 1){
			echo 'ERROR: attept to re-assign student to leftover table<br/>';	
		}
		else{
			array_push($leftover_table,$sl_student);
		}
	}
}

echo "DONE! &#13;&#10&#13;&#10";
ob_flush();
flush();

// END SAME ROOM //

// RENEWAL: FINDS ALL STUDENTS WHO ARE RENEWING THERE LEASE//

echo "ASSIGNING RENEWAL STUDENTS...&#13;&#10";
ob_flush();
flush();

foreach ($renewList as $rl_student){
	$rl = "SELECT req_room_num, req_build_id FROM students WHERE student_id = $rl_student AND room_num=0";
	$rl_result = mysqli_query($dbconn, $rl);

	while ($row = mysqli_fetch_array($rl_result)) {
		$room_num = $row['req_room_num'];
		$build_id = $row['req_build_id'];
	}

	if ($room_num != 0 && check_room ($rl_student,$room_num,$build_id)== 1){
		if(assign_student ($rl_student,$build_id . $room_num,$room_num,$build_id) == 1){
		//	echo '.';
		}
		else{
			$test = in_array($rl_student,$leftover_table);
			if( $test == 1){
				echo 'ERROR: attept to re-assign student to leftover table<br/>';	
			}
			else{
				array_push($leftover_table,$rl_student);
			}
		}
	}
	else{
		$test = in_array($rl_student,$leftover_table);
		if( $test == 1){
			echo 'ERROR: attept to re-assign student to leftover table<br/>';	
		}
		else
		{
			array_push($leftover_table,$rl_student);
		}
	}
}

echo "DONE! &#13;&#10&#13;&#10";
ob_flush();
flush();

//END RENEWAL//


//POPLULATE: FILLS ALL EMPTY ROOMS WITH LEFTOVER STUDENTS //
echo "FILLING ROOMS WITH LEFTOVER RENEWAL/SAME STUDENTS...&#13;&#10";
ob_flush();
flush();

for($h=0;$h<count($leftover_table);$h++){
	$test = populate_room($leftover_table[$h]);
	if($test == 1){
	}else{
		array_push($leftover_table2,$leftover_table[$h++]);
	}
}

assign_list($leftover_table2);

echo "DONE! &#13;&#10&#13;&#10";
ob_flush();
flush();
//END POPULATE //


//OTHER STUDENTS: ALL STUDENTS WITHOUT ROOMS NOW GET ASSIGNED //

echo "ASSIGNING ALL OTHER STUDENTS...&#13;&#10";
ob_flush();
flush();

$otherStudents = "SELECT * FROM students WHERE room_num=0";
$otherStudentsRes = mysqli_query($dbconn, $otherStudents);

while ($oStudent = mysqli_fetch_array($otherStudentsRes)) {
	$ost_id = $oStudent['student_id'];
	
	$test = populate_room($ost_id);
	if($test == 1){
	}else{
		array_push($leftover_table3,$ost_id);
	}
}
	
assign_list($leftover_table3);

echo "DONE! &#13;&#10&#13;&#10";
ob_flush();
flush();

//END OTHER STUDENTS //

// FIND ROOMS WITH 1 STUDENTS //
echo "REARRANGING STUDENTS...&#13;&#10";
ob_flush();
flush();
/*
$oneStudentRooms = array();
$badRoomStudent = array();

$buildings = "SELECT build_id FROM building WHERE complex=0";
$buildingsRes = mysqli_query($dbconn, $buildings);

while ($build = mysqli_fetch_array($buildingsRes)) {
	$build_id = $build['build_id'];
	
	$reqRoomSame = "SELECT student_id FROM students WHERE build_id='$build_id' AND room_num<>req_room_num";
	$reqRoomSameRes = mysqli_query($dbconn, $reqRoomSame);

	$std_id2; 
	while ($stu = mysqli_fetch_array($reqRoomSameRes)) {
		$std_id2 = $stu['student_id'];
		array_push($badRoomStudent,$std_id2);
	}

	$oneStudentRooms = one_std_rooms($build_id);

	$count = 0;
	do{
		if(empty($badRoomStudent)){
			assign_std_empty($badRoomStudent[$count],$build_id);
			$badRoomsStudent = one_std_rooms($build_id);	
		}
		
		$roomsList = "SELECT room_num FROM rooms WHERE build_id = $build_id";
		$roomsListRes = mysqli_query($dbconn, $roomsList);
		
		$allBuildRooms = array();
		while ($buildRooms = mysqli_fetch_array($roomsListRes)) {
			$aRoom = $buildRooms['room_num'];
			array_push($allBuildRooms,$aRoom);
		}
		
		assign_by_prefs2($badRoomStudent[$count],$allBuildRooms,$build_id);		
		$count ++;
		if($count > count($badRoomStudent)){
			print_r($badRoomStudent);
			break;
		}

	}while(!empty($badRoomStudent));

}
*/
echo "DONE ! &#13;&#10&#13;&#10";
ob_flush();
flush();

// END FIND STUDENTS //

// END ALGORITHM

echo "-------------- COMPLETED ---------------</textarea></div>";
ob_flush();
flush();
sleep(2);

// REDIRECTION
print<<<END
<script>
window.location="../../settings.php?validate=Students have been assigned according to our algorithm! <br/>Please check the manage page to see the results and make changes.";
</script>
END;

?>
