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
	include ('../../../includes/svrConnect.php');
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


/**
* <pre>
* ASSIGN_STUDENT: Assigns a student to a room.
* TAKES: Student ID, Room Number, and Building ID.
* RETURNS: 0 if the student was not placed into that room.
* 	  1 if the student was placed into that room.
*</pre>
*/
function assign_student ($std_id,$group_id,$room_num,$build_id){
	include ('../../../includes/svrConnect.php');
	$room_info = "SELECT num_students FROM rooms WHERE room_num='$room_num' AND build_id='$build_id'";
	$r_info = mysqli_query($dbconn, $room_info);

	while ($row = mysqli_fetch_array($r_info)) {
		$rFull = $row['num_students'];
	}
	$rFull ++;
	$flag = 0;

	$checkGroup = "SELECT group_id FROM groups";
	$chkGroup = mysqli_query($dbconn, $checkGroup);

	while ($row = mysqli_fetch_array($chkGroup)) {
		if($row['group_id'] == $group_id){
			$flag = 1;
		}
	}

	if($flag == 1){
		if($rFull == 2){ //updates second student
			$up_groups = "UPDATE `groups` SET `student_id_2`='$std_id' WHERE group_id='$group_id'";
			$upGroup = mysqli_query($dbconn, $up_groups);
			$up_room = "UPDATE `rooms` SET `num_students`='$rFull', group_id='$group_id' WHERE room_num='$room_num' AND build_id='$build_id'";
			$up_students = "UPDATE `students` SET `room_num`='$room_num', group_id='$group_id', build_id='$build_id' WHERE student_id='$std_id'";
			$up_room_let = "UPDATE `room_letter` SET `student_id`='$std_id' WHERE room_num='$room_num' AND build_id='$build_id' AND letter='B'";
			$upRoomLet = mysqli_query($dbconn, $up_room_let);
			$upRooms = mysqli_query($dbconn, $up_room);
			$upStudents = mysqli_query($dbconn, $up_students);
			return 1;
		}	
		elseif($rFull == 3){ //updates third student
			$up_groups = "UPDATE `groups` SET `student_id_3`='$std_id' WHERE group_id='$group_id'";
			$upGroup = mysqli_query($dbconn, $up_groups);
			$up_room = "UPDATE `rooms` SET `num_students`='$rFull', group_id='$group_id' WHERE room_num='$room_num' AND build_id='$build_id'";
			$up_students = "UPDATE `students` SET `room_num`='$room_num', group_id='$group_id', build_id='$build_id' WHERE student_id='$std_id'";
			$up_room_let = "UPDATE `room_letter` SET `student_id`='$std_id' WHERE room_num='$room_num' AND build_id='$build_id' AND letter='C'";
			$upRoomLet = mysqli_query($dbconn, $up_room_let);
			$upRooms = mysqli_query($dbconn, $up_room);
			$upStudents = mysqli_query($dbconn, $up_students);
			return 1;
		}	
		elseif($rFull == 4){ //updates fourth student
			$up_groups = "UPDATE `groups` SET `student_id_4`='$std_id' WHERE group_id='$group_id'";
			$upGroup = mysqli_query($dbconn, $up_groups);
			$up_room = "UPDATE `rooms` SET `num_students`='$rFull', group_id='$group_id' WHERE room_num='$room_num' AND build_id='$build_id'";
			$up_students = "UPDATE `students` SET `room_num`='$room_num', group_id='$group_id', build_id='$build_id' WHERE student_id='$std_id'";
			$up_room_let = "UPDATE `room_letter` SET `student_id`='$std_id' WHERE room_num='$room_num' AND build_id='$build_id' AND letter='D'";
			$upRoomLet = mysqli_query($dbconn, $up_room_let);
			$upRooms = mysqli_query($dbconn, $up_room);
			$upStudents = mysqli_query($dbconn, $up_students);
			return 1;
		}else{
			return 0;
		}
		$flag = 0;
	}else{
		$in_group = "INSERT INTO `groups`(`group_id`, `build_id`, `room_num`, `student_id_1`, `student_id_2`, `student_id_3`, `student_id_4`) VALUES ('$group_id','$build_id','$room_num','$std_id',0,0,0)";
		$inGroup = mysqli_query($dbconn, $in_group);
		$up_room = "UPDATE `rooms` SET `num_students`='$rFull', group_id='$group_id' WHERE room_num='$room_num' AND build_id='$build_id'";
		$up_students = "UPDATE `students` SET `room_num`='$room_num', group_id='$group_id', build_id='$build_id' WHERE student_id='$std_id'";
		$up_room_let = "UPDATE `room_letter` SET `student_id`='$std_id' WHERE room_num='$room_num' AND build_id='$build_id' AND letter='A'";
		$upRoomLet = mysqli_query($dbconn, $up_room_let);
		$upRooms = mysqli_query($dbconn, $up_room);
		$upStudents = mysqli_query($dbconn, $up_students);
		return 1;
	}	
}


/**
* <pre>
* IMP_PREFS: Finds the top 2 most imporant preferences of the student it is given.
* TAKES: Student ID.
* RETURNS: an Array containing the top 2 prefernces of the studnet ID given.
*</pre>
*/
function imp_prefs($std_id){
	include ('../../../includes/svrConnect.php');
	$high_array = array();

	$stds = "SELECT cleanliness, noise, guest_sleeping, share_belongings, bed_time, wakeup_time, gathering, drink_alchohol, others_drink, smoking, others_smoking, noise_rating, cleanliness_rating, lifestyle_rating, age_rating, major_rating, guest_rating FROM students WHERE student_id='$std_id'";
	$stds_result = mysqli_query($dbconn, $stds) or die ('Error ' . mysqli_error($dbconn));
	while ($row3 = mysqli_fetch_array($stds_result)) {
		$noise_rating = $row3['noise_rating'];
		$cleanliness_rating = $row3['cleanliness_rating'];
		$lifestyle_rating = $row3['lifestyle_rating'];
		$age_rating = $row3['age_rating'];
		$major_rating = $row3['major_rating'];
		$guest_rating = $row3['guest_rating'];

		$first = $noise_rating;
		$second = 0;
		$flag = 0;
		$firstName = "noise_rating";
		$secondName = "";

		if($cleanliness_rating > $first){
			$secondName = $firstName;
			$firstName = "cleanliness_rating";
			$first = $cleanliness_rating;
		}	
		if($lifestyle_rating > $first){
			$secondName = $firstName;
			$firstName = "lifestyle_rating";
			$first = $lifestyle_rating;
		}	
		if($age_rating > $first){
			$secondName = $firstName;
			$firstName = "age_rating";
			$first = $age_rating;
		}	
		if($major_rating > $first){
			$secondName = $firstName;
			$firstName = "major_rating";
			$first = $major_rating;
		}	
		if($guest_rating > $first){
			$secondName = $firstName;
			$firstName = "guest_rating";
			$first = $guest_rating;
		}

		if($secondName == ""){
			if($cleanliness_rating > $second){
				$secondName = "cleanliness_rating";
				$second = $cleanliness_rating;
			}	
			if($lifestyle_rating > $second){
				$secondName = "lifestyle_rating";
				$second = $lifestyle_rating;
			}	
			if($age_rating > $second){
				$secondName = "age_rating";
				$second = $age_rating;
			}	
			if($major_rating > $second){
				$secondName = "major_rating";
				$second = $major_rating;
			}	
			if($guest_rating > $second){
				$secondName = "guest_rating";
				$second = $guest_rating;
			}
		}

		array_push($high_array,$firstName);
		array_push($high_array,$secondName);
	}
	return ($high_array);
}


/**
* <pre>
* POPULATE_ROOM: Places a student into a empty room.
* TAKES: Student ID.
* RETURNS: 0 if the student could not be placed anywhere.
* 	  1 if the student was placed into a empty room.
*</pre>
*/
function populate_room($std_id){
	include ('../../../includes/svrConnect.php');

	$buildings = "SELECT build_id FROM building WHERE complex = 0";
	$build_list = mysqli_query($dbconn, $buildings) or die ('Error ' . mysqli_error($dbconn));

	while ($build = mysqli_fetch_array($build_list)) {
		$b_id = $build['build_id'];
		$rooms = "SELECT room_num FROM rooms WHERE build_id='$b_id' AND num_students=0";
		$rooms_list = mysqli_query($dbconn, $rooms) or die ('Error ' . mysqli_error($dbconn));
		
		while ($room = mysqli_fetch_array($rooms_list)) {
			$groupID = $build['build_id']. $room['room_num'];
			$room_num = $room['room_num'];
	
			if ((check_room ($std_id,$room_num,$build['build_id'])== 1)){
				$test = assign_student($std_id,$groupID,$room_num,$build['build_id']);
				return 1;
			}
		}
	}
	return 0;
}


/**
* <pre>
* ASSIGN_LIST: Loops though a list of students and assigns them to a room based on there preferences.
* TAKES: An Array of Student ID's.
* RETURNS: Nothing
*</pre>
*/
function assign_list($list){
	include ('../../../includes/svrConnect.php');
	$total = 0;
	$badStudents = array();

	for ($i=0; $i<count($list);$i++){
		$builds = array();
		$test = 1;
		$builds2 = array();
		$buildings = "SELECT build_id FROM students WHERE student_id = $list[$i]";
		$build_list = mysqli_query($dbconn, $buildings) or die ('Error ' . mysqli_error($dbconn));

		while ($row = mysqli_fetch_array($build_list)) {
			$test = $row['build_id'];
			array_push($builds, $row['build_id']);	
		}

		if ($test == 0){
			$allBuildings = "SELECT build_id FROM building WHERE complex = 0";
			$build_list2 = mysqli_query($dbconn, $allBuildings) or die ('Error ' . mysqli_error($dbconn));

			while ($row = mysqli_fetch_array($build_list2)) {
				array_push($builds2, $row['build_id']);	
			}
			$total = assign_by_prefs($list[$i],$builds2);
		}else{
			$total = assign_by_prefs($list[$i],$builds);
		}

		if($total == 1){
		}else{
			array_push($badStudents,$list[$i]);	
		}
	}
}

/**
* <pre>
* ASSIGN_BY_PREFS2: Places a student into that room that best fits his/hers preferences.
* TAKES: Student ID, Room Number, and Building ID.
* RETURNS: 0 if the student could not be placed anywhere.
* 	  1 if the student was placed into a room.
*</pre>
*/
function assign_by_prefs2($std_id, $rooms, $build_id){
	include ('../../../includes/svrConnect.php');
	$room_num;
	$diff = 9999999;
	$first_time = 0;
	$roomSet = array();
	$roomVal = array();
	$allStudents = array();
	$oneStudent = array();
	$roomAvg = array();
	$bestAvg = array();

	$roomAvg['build_id'] = 0;
	$roomAvg['room_num'] = 0;
	$roomAvg['cleanliness'] = 999;
	$roomAvg['noise'] = 999;
	$roomAvg['guest_sleeping'] = 999;
	$roomAvg['share_belongings'] = 9999;
	$roomAvg['bed_time'] = 999;
	$roomAvg['wakeup_time'] = 999;
	$roomAvg['gathering'] = 999;
	$roomAvg['drink_alchohol'] = 999;
	$roomAvg['others_drink'] = 999;
	$roomAvg['smoking'] = 999;
	$roomAvg['others_smoking'] = 999;

	$roomAvg['noise_rating'] = 999;
	$roomAvg['cleanliness_rating'] = 999;
	$roomAvg['lifestyle_rating'] = 999;
	$roomAvg['age_rating'] = 999;
	$roomAvg['major_rating'] = 999;
	$roomAvg['guest_rating'] = 999;
	
	$bestAvg['build_id'] = 0;
	$bestAvg['room_num'] = 0;

		$roomAvg['build_id'] = $build_id;

		for($i=0;$i<count($rooms);$i++){
			$room_val = $rooms[$i];
			$roomAvg['room_num'] = $room_val;

			$grps = "SELECT DISTINCT group_id, num_students FROM rooms WHERE room_num = '$room_val' AND build_id = '$build_id'";
			$grps_result = mysqli_query($dbconn, $grps);
			while ($row2 = mysqli_fetch_array($grps_result)) {
				$grp = $row2['group_id'];
				$num_s = $row2['num_students'];

				if($num_s != 4){

					$stds = "SELECT student_id, cleanliness, noise, guest_sleeping, share_belongings, bed_time, wakeup_time, gathering, drink_alchohol, others_drink, smoking, others_smoking, noise_rating, cleanliness_rating, lifestyle_rating, age_rating, major_rating, guest_rating FROM students WHERE group_id = '$grp'";

					$test2 = array();
					$test2 = (imp_prefs($std_id));
					foreach ($test2 as $val ){
						if(in_array($val,$roomSet)){
							$doNothing = 1;
						}
						else{
							array_push($roomSet,$val);
						}
					}

					$count = 0;
					$stds_result = mysqli_query($dbconn, $stds) or die ('Error ' . mysqli_error($dbconn));
					while ($row3 = mysqli_fetch_array($stds_result)) {
						$first_time ++;
						$oneStudent['student_id'] = $student_id = $row3['student_id'];

						$oneStudent['cleanliness'] = $cleanliness = $row3['cleanliness']; 
						$oneStudent['noise'] = $noise = $row3['noise'];
						$oneStudent['guest_sleeping'] = $guest_sleeping = $row3['guest_sleeping'];
						$oneStudent['share_belongings'] = $share_belongings = $row3['share_belongings'];
						$oneStudent['bed_time'] = $bed_time = $row3['bed_time'];
						$oneStudent['wakeup_time'] = $wakeup_time = $row3['wakeup_time']; 
						$oneStudent['gathering'] = $gathering = $row3['gathering'];
						$oneStudent['drink_alchohol'] = $drink_alcohol = $row3['drink_alchohol'];
						$oneStudent['others_drink'] = $others_drink = $row3['others_drink'];
						$oneStudent['smoking'] = $smoking = $row3['smoking'];
						$oneStudent['others_smoking'] = $other_smoking = $row3['others_smoking'];

						$oneStudent['noise_rating'] = $noise_rating = $row3['noise_rating'];
						$oneStudent['cleanliness_rating'] = $cleanliness_rating = $row3['cleanliness_rating'];
						$oneStudent['lifestyle_rating'] = $lifestyle_rating = $row3['lifestyle_rating'];
						$oneStudent['age_rating'] = $age_rating = $row3['age_rating'];
						$oneStudent['major_rating'] = $major_rating = $row3['major_rating'];
						$oneStudent['guest_rating'] = $guest_rating = $row3['guest_rating'];

						$allStudents[$count] = $oneStudent;
						$count ++;

						$test = array();
						$test = (imp_prefs($student_id));
						foreach ($test as $val ){
							if(in_array($val,$roomSet)){
								$doNothing = 1;
							}
							else{
								array_push($roomSet,$val);
							}
						}
					}

					$start = 1;
					for($y=0;$y<count($allStudents);$y++){
						$start ++;
						foreach($allStudents[$y] as $key =>$val){	
							if(in_array($key,$roomSet))
							{
								if($start == 2){
									$roomAvg[$key] = 0;
								}
								$roomAvg[$key] += $val;
							}
						}
					}
					foreach($roomAvg as $key =>$val){
						if($start != 0){
							$div = $val / $start;
						}else{
							$div = 0.000001;
							echo "ZERO DIVISION";
						}
		
						
						if($key == "build_id" || $key == "room_num"){
						}else{
							$roomAvg[$key] = $div;
						}
					}
					if($first_time == 1){
						foreach($roomAvg as $key =>$val){
							$bestAvg[$key] = $val;
						}
					}else{
						$std_pref = "SELECT student_id, cleanliness, noise, guest_sleeping, share_belongings, bed_time, wakeup_time, gathering, drink_alchohol, others_drink, smoking, others_smoking, noise_rating, cleanliness_rating, lifestyle_rating, age_rating, major_rating, guest_rating FROM students WHERE student_id = '$std_id'";
						$std_all_prefs = mysqli_query($dbconn, $std_pref);
						$curDiff = 0;

						while ($row3 = mysqli_fetch_array($std_all_prefs)) {
							$cleanliness = $row3['cleanliness']; 
							$noise = $row3['noise'];
							$guest_sleeping = $row3['guest_sleeping'];
							$share_belongings = $row3['share_belongings'];
							$bed_time = $row3['bed_time'];
							$wakeup_time = $row3['wakeup_time']; 
							$gathering = $row3['gathering'];
							$drink_alcohol = $row3['drink_alchohol'];
							$others_drink = $row3['others_drink'];
							$smoking = $row3['smoking'];


							//echo "<br/>--------COMPARE-------";
							foreach($roomAvg as $key =>$val){
								if($key == "build_id" || $key == "room_num"){
									//echo "<br/>Current - $key: $val";
								}else{
									//echo "<br/>Current - $key: $val";
									$curDiff += abs($row3[$key] - $val);
								}
							}
						}
						$temp3 = $roomAvg['build_id'];
						$temp4 = $roomAvg['room_num'];

						//	echo "<br/><br/>CurDiff $curDiff: BestDiff $diff<br/>";
						if (($curDiff < $diff) && (check_room ($std_id,$temp4,$temp3)== 1)){
							$diff = $curDiff;

							foreach($roomAvg as $key =>$val){
								//echo "<br/>Best - $key: $val";
								$bestAvg[$key] = $val;
							}
						}							
					}
				}
			}
		}
	if($bestAvg['build_id'] == 0 || $bestAvg['room_num'] == 0){
		return 0;
	}
	$groupID = $bestAvg['build_id'] . $bestAvg['room_num'];	
	$temp1 = $bestAvg['build_id'];
	$temp2 = $bestAvg['room_num'];

	if ((check_room ($std_id,$temp2,$temp1)== 1)){
		return (assign_student($std_id,$groupID,$bestAvg['room_num'],$bestAvg['build_id']));
	}else{
		return 0;
	}
}


/**
* <pre>
* ASSIGN_BY_PREFS: Places a student into that room that best fits his/hers preferences.
* TAKES: Student ID, and Building ID.
* RETURNS: 0 if the student could not be placed anywhere.
* 	  1 if the student was placed into a room.
*</pre>
*/
function assign_by_prefs($std_id, $builds){
	include ('../../../includes/svrConnect.php');
	$room_num;
	$diff = 9999999;
	$first_time = 0;
	$roomSet = array();
	$roomVal = array();
	$allStudents = array();
	$oneStudent = array();
	$roomAvg = array();
	$bestAvg = array();

	$roomAvg['build_id'] = 0;
	$roomAvg['room_num'] = 0;
	$roomAvg['cleanliness'] = 999;
	$roomAvg['noise'] = 999;
	$roomAvg['guest_sleeping'] = 999;
	$roomAvg['share_belongings'] = 9999;
	$roomAvg['bed_time'] = 999;
	$roomAvg['wakeup_time'] = 999;
	$roomAvg['gathering'] = 999;
	$roomAvg['drink_alchohol'] = 999;
	$roomAvg['others_drink'] = 999;
	$roomAvg['smoking'] = 999;
	$roomAvg['others_smoking'] = 999;

	$roomAvg['noise_rating'] = 999;
	$roomAvg['cleanliness_rating'] = 999;
	$roomAvg['lifestyle_rating'] = 999;
	$roomAvg['age_rating'] = 999;
	$roomAvg['major_rating'] = 999;
	$roomAvg['guest_rating'] = 999;

	$bestAvg['build_id'] = 0;
	$bestAvg['room_num'] = 0;

	for ($i =0; $i < count($builds); $i++){
		$room_list = "SELECT DISTINCT room_num FROM students WHERE build_id = '$builds[$i]'";
		$room_list_result = mysqli_query($dbconn, $room_list) or die ('Error ' . mysqli_error($dbconn));
		$roomAvg['build_id'] = $builds[$i];

		//echo "___Building: $builds[$i]<br/>";
		while ($row = mysqli_fetch_array($room_list_result)) {
			$room_val = $row['room_num'];
			$roomAvg['room_num'] = $room_val;
			//echo "______Room: $room_val<br/>";

			$grps = "SELECT DISTINCT group_id, num_students FROM rooms WHERE room_num = '$room_val' AND build_id = '$builds[$i]'";
			$grps_result = mysqli_query($dbconn, $grps);
			while ($row2 = mysqli_fetch_array($grps_result)) {
				$grp = $row2['group_id'];
				$num_s = $row2['num_students'];

				if($num_s != 4){

					$stds = "SELECT student_id, cleanliness, noise, guest_sleeping, share_belongings, bed_time, wakeup_time, gathering, drink_alchohol, others_drink, smoking, others_smoking, noise_rating, cleanliness_rating, lifestyle_rating, age_rating, major_rating, guest_rating FROM students WHERE group_id = '$grp'";
					//echo "Group: $grp<br/><br/>";

					$test2 = array();
					$test2 = (imp_prefs($std_id));
					foreach ($test2 as $val ){
						if(in_array($val,$roomSet)){
							$doNothing = 1;
						}
						else{
							array_push($roomSet,$val);
						}
					}

					$count = 0;
					$stds_result = mysqli_query($dbconn, $stds) or die ('Error ' . mysqli_error($dbconn));
					while ($row3 = mysqli_fetch_array($stds_result)) {
						$first_time ++;
						$oneStudent['student_id'] = $student_id = $row3['student_id'];

						$oneStudent['cleanliness'] = $cleanliness = $row3['cleanliness']; 
						$oneStudent['noise'] = $noise = $row3['noise'];
						$oneStudent['guest_sleeping'] = $guest_sleeping = $row3['guest_sleeping'];
						$oneStudent['share_belongings'] = $share_belongings = $row3['share_belongings'];
						$oneStudent['bed_time'] = $bed_time = $row3['bed_time'];
						$oneStudent['wakeup_time'] = $wakeup_time = $row3['wakeup_time']; 
						$oneStudent['gathering'] = $gathering = $row3['gathering'];
						$oneStudent['drink_alchohol'] = $drink_alcohol = $row3['drink_alchohol'];
						$oneStudent['others_drink'] = $others_drink = $row3['others_drink'];
						$oneStudent['smoking'] = $smoking = $row3['smoking'];
						$oneStudent['others_smoking'] = $other_smoking = $row3['others_smoking'];

						$oneStudent['noise_rating'] = $noise_rating = $row3['noise_rating'];
						$oneStudent['cleanliness_rating'] = $cleanliness_rating = $row3['cleanliness_rating'];
						$oneStudent['lifestyle_rating'] = $lifestyle_rating = $row3['lifestyle_rating'];
						$oneStudent['age_rating'] = $age_rating = $row3['age_rating'];
						$oneStudent['major_rating'] = $major_rating = $row3['major_rating'];
						$oneStudent['guest_rating'] = $guest_rating = $row3['guest_rating'];

						$allStudents[$count] = $oneStudent;
						$count ++;

						//echo "$cleanliness, $noise, $guest_sleeping, $share_belongings, $bed_time, $wakeup_time, $gathering, $drink_alcohol, $others_drink, $smoking, $other_smoking, $noise_rating, $cleanliness_rating, $lifestyle_rating, $age_rating, $major_rating, $guest_rating<br/>";

						$test = array();
						$test = (imp_prefs($student_id));
						foreach ($test as $val ){
							if(in_array($val,$roomSet)){
								$doNothing = 1;
							}
							else{
								array_push($roomSet,$val);
							}
						}
					}

					$start = 0;
					for($y=0;$y<count($allStudents);$y++){
						$start ++;
						foreach($allStudents[$y] as $key =>$val){	
							if(in_array($key,$roomSet))
							{
								if($start == 1){
									$roomAvg[$key] = 0;
								}
								$roomAvg[$key] += $val;
							}
						}
					}

					foreach($roomAvg as $key =>$val){
						$div = $val / $start;

						if($key == "build_id" || $key == "room_num"){
						}else{
							$roomAvg[$key] = $div;
						}
					}
					if($first_time == 1){
						foreach($roomAvg as $key =>$val){
							$bestAvg[$key] = $val;
						}
					}else{
						$std_pref = "SELECT student_id, cleanliness, noise, guest_sleeping, share_belongings, bed_time, wakeup_time, gathering, drink_alchohol, others_drink, smoking, others_smoking, noise_rating, cleanliness_rating, lifestyle_rating, age_rating, major_rating, guest_rating FROM students WHERE student_id = '$std_id'";
						$std_all_prefs = mysqli_query($dbconn, $std_pref);
						$curDiff = 0;

						while ($row3 = mysqli_fetch_array($std_all_prefs)) {
							$cleanliness = $row3['cleanliness']; 
							$noise = $row3['noise'];
							$guest_sleeping = $row3['guest_sleeping'];
							$share_belongings = $row3['share_belongings'];
							$bed_time = $row3['bed_time'];
							$wakeup_time = $row3['wakeup_time']; 
							$gathering = $row3['gathering'];
							$drink_alcohol = $row3['drink_alchohol'];
							$others_drink = $row3['others_drink'];
							$smoking = $row3['smoking'];

							//echo "<br/>--------COMPARE-------";
							foreach($roomAvg as $key =>$val){
								if($key == "build_id" || $key == "room_num"){
									//echo "<br/>Current - $key: $val";
								}else{
									//echo "<br/>Current - $key: $val";
									$curDiff += abs($row3[$key] - $val);
								}
							}
						}
						$temp3 = $roomAvg['build_id'];
						$temp4 = $roomAvg['room_num'];

						//	echo "<br/><br/>CurDiff $curDiff: BestDiff $diff<br/>";
						if (($curDiff < $diff) && (check_room ($std_id,$temp4,$temp3)== 1)){
							$diff = $curDiff;

							foreach($roomAvg as $key =>$val){
								//echo "<br/>Best - $key: $val";
								$bestAvg[$key] = $val;
							}
						}							
					}
				}
			}
		}
	}
	if($bestAvg['build_id'] == 0 || $bestAvg['room_num'] == 0){
		return 0;
	}

	$groupID = $bestAvg['build_id'] . $bestAvg['room_num'];	
	$temp1 = $bestAvg['build_id'];
	$temp2 = $bestAvg['room_num'];

	if ((check_room ($std_id,$temp2,$temp1)== 1)){
		return (assign_student($std_id,$groupID,$bestAvg['room_num'],$bestAvg['build_id']));
	}else{
		return 0;
	}
}


/**
* <pre>
* NON_FULL_ROOMS: Finds rooms that are not currently full.
* TAKES: Building ID.
* RETURNS: An Array of rooms in that building that are not full.
*</pre>
*/
function non_full_rooms($building){
	include ('../../../includes/svrConnect.php');
	$one_std_arr = array();
	$rooms = "SELECT room_num FROM rooms WHERE num_students < '4' AND num_students > '0' AND build_id = '$building'";
	$rooms_result = mysqli_query($dbconn, $rooms);

	while ($rooms2 = mysqli_fetch_array($rooms_result)) 
	{
		foreach($rooms2 as $val)
		{
			array_push($one_std_arr, $val);
		}
	}
	return $one_std_arr;
}


/**
* <pre>
* ASSIGN_STD_EMPTY: Places a student into a empty room.
* TAKES: Student ID.
* RETURNS: 0 if the student could not be placed anywhere.
* 	  1 if the student was placed into a room.
*</pre>
*/
function assign_std_empty($std_id){
	include ('../../../includes/svrConnect.php');
	$rooms = "SELECT room_num, build_id FROM rooms WHERE num_students = '0' ";
	$rooms_result = mysqli_query($dbconn, $rooms);

	while ($rooms2 = mysqli_fetch_array($rooms_result)) 
	{
		$room_val = $rooms2['room_num'];
		$build_val = $rooms2['build_id'];
	}
	$group_id = $build_val . $room_val;
	if(assign_student ($std_id,$group_id,$room_val,$build_val))
	{
		return 1;
	}
	return 0;
}


/**
* <pre>
* ASSIGN_STD_EMPTY: Places a student into a empty room.
* TAKES: Student ID.
* RETURNS: 0 if the student could not be placed anywhere.
* 	  1 if the student was placed into a room.
*</pre>
*/
function assign_std_empty2($std_id)
{
	$empty_r3 = "SELECT room_num, build_id from rooms WHERE num_students = '0'";
	$empty_room_result3 = mysqli_query($dbconn, $empty_r3);
	while($e_room3 = mysqli_fetch_array($empty_room_result3))
	{
		$count = 0;
		foreach ($e_room3 as $val)
		{
			if ($count%2 ==1)
			{
				if (assign_student ($std_id, $prev_val . $val, $prev_val , $val ) ==1);
				{
					return 1;
				}
			}
			else
			{
				$prev_val = $val;
			}
			$count++;
		}
	}
	return 0;

}


/**
* <pre>
* ASSIGN_QUARTER: Assigns a quarter of the students in the array it was given. 
* TAKES: Array of Student ID's.
* RETURNS: Same the array it was given, minus a quarter of the students
*</pre>
*/
function assign_quarter($list)
{
	include ('../../../includes/svrConnect.php');

	$val_room = 0;	
	$val_build = 0;
	$e_val_room = 0;	
	$e_val_build = 0;

	for ($i = 0; $i < count($list)/4; $i++)
	{
		$requested_room = "SELECT req_room_num, req_build_id FROM students WHERE student_id = '$list[$i]'";
		$req_room_result = mysqli_query($dbconn, $requested_room);

		while($requested_room = mysqli_fetch_array($req_room_result))
		{
			$req_room = $requested_room['req_room_num'];
			$req_build = $requested_room['req_build_id'];

			/* assign to requested room if student requested one and its empty */
			if ((($req_room != 0) && ($req_room != NULL)) && (($req_build != 0) && ($req_build != NULL)))
			{
				$empty_room = "SELECT room_num, build_id from rooms WHERE room_num = '$val_room' AND build_id = '$val_build' AND num_students = '0'";
				$empty_room_result = mysqli_query($dbconn, $empty_room);
				while($e_room = mysqli_fetch_array($empty_room_result))
				{
					$e_val_room = $e_room['room_num'];
					$e_val_build = $e_room['room_build_id'];
					if ((($e_val_room != 0) && ($e_val_room != NULL)) && (($e_val_build != 0) && ($e_val_build != NULL)))
					{
						if(assign_student ($list[$i],$e_val_room . $e_val_build, $e_val_room,$e_val_build))
						{
							unset($list[$i]);
						}
					}
					else /* assign to random empty room*/
					{
						$empty_r2 = "SELECT room_num, build_id FROM rooms WHERE num_students = '0'";
						$empty_room_result2 = mysqli_query($dbconn, $empty_r2);
						while($e_room2 = mysqli_fetch_array($empty_room_result2))
						{
							$count = 0;
							$prev_val;
							$val;
							foreach ($e_room2 as $val)
							{
								if ($count%2 ==1)
								{
									if (assign_student ($list[$i], $prev_val .$val, $prev_val, $val ) == 1);
									{
										unset($list[$i]);
										break 2;
									}
								}
								else
								{
									$prev_val = $val;
								}
								$count++;
							}
						}

					}
				}
			}
			else /* no requested room, assign to random empty room*/
			{
				$empty_r3 = "SELECT room_num, build_id from rooms WHERE num_students = '0'";
				$empty_room_result3 = mysqli_query($dbconn, $empty_r3);
				while($e_room3 = mysqli_fetch_array($empty_room_result3))
				{
					$count = 0;
					foreach ($e_room3 as $val)
					{
						if ($count%2 ==1)
						{
							if (assign_student ($list[$i], $prev_val . $val, $prev_val, $val ) ==1);
							{
								unset($list[$i]);
								break 2;
							}
						}
						else
						{
							$prev_val = $val;
						}
						$count++;
					}
				}
				
			}

		}
	}//end for students
	return $list;
}


/**
* <pre>
* ASSIGN_QUARTER: Assigns a quarter of the students in the array it was given. 
* TAKES: Array of Student ID's.
* RETURNS: Same the array it was given, minus a quarter of the students
*</pre>
*/
function assign_quarter2($list)
{
	include ('../../../includes/svrConnect.php');

	$val_room = 0;	
	$val_build = 0;
	$e_val_room = 0;	
	$e_val_build = 0;

	for ($i = 0; $i < count($list)/4; $i++)
	{
		$requested_room = "SELECT req_room_num, req_build_id FROM students WHERE student_id = '$list[$i]'";
		$req_room_result = mysqli_query($dbconn, $requested_room);
/*		if(isset($req_room_result))*/
		while($requested_room = mysqli_fetch_array($req_room_result))
		{
			$req_room = $requested_room['req_room_num'];
			$req_build = $requested_room['req_build_id'];

			/* assign to requested room if student requested one and its empty */
			if ((($req_room != 0) && ($req_room != NULL)) && (($req_build != 0) && ($req_build != NULL)))
			{
				$empty_room = "SELECT room_num, build_id from rooms WHERE room_num = '$val_room' AND build_id = '$val_build' AND num_students = '0'";
				$empty_room_result = mysqli_query($dbconn, $empty_room);
				while($e_room = mysqli_fetch_array($empty_room_result))
				{
					$e_val_room = $e_room['room_num'];
					$e_val_build = $e_room['room_build_id'];
					if ((($e_val_room != 0) && ($e_val_room != NULL)) && (($e_val_build != 0) && ($e_val_build != NULL)))
					{
						if(assign_student ($list[$i],$e_val_room . $e_val_build, $e_val_room ,$e_val_build))
						{
							unset($list[$i]);
						}
					}

					else /* assign to random empty room*/
					{
						if(assign_std_empty($list[$i]))
						{
							unset($list[$i]);
						}
					}
				}
			}
			else /* no requested room, assign to random empty room*/
			{
				if(assign_std_empty($list[$i]))
				{
					unset($list[$i]);
				}
			}

		}
	}//end for students
	return $list;
}
?>
