<?php
	include ('../../includes/svrConnect.php');
	$was_errors = false;
	$errors = array();
	// escape variables for security
	$valid = 0;
	//str_replace(' ', '_', $name);
	$student_id = mysqli_real_escape_string($dbconn, $_POST['student_id']);
	$first_name = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['first_name']));
	$last_name = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['last_name']));
	$gender = mysqli_real_escape_string($dbconn, $_POST['gender']);
	$birthdate = mysqli_real_escape_string($dbconn, $_POST['birthdate']);
	$cell_phone = mysqli_real_escape_string($dbconn, $_POST['cell_phone']);
	$home_phone = mysqli_real_escape_string($dbconn, $_POST['home_phone']);
	$email = str_replace('@', '_',mysqli_real_escape_string($dbconn, $_POST['email']));
	$address1 = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['address1']));
	$address2 = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['address2']));
	$city = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['city']));
	$state = mysqli_real_escape_string($dbconn, $_POST['state']);
	$zip = mysqli_real_escape_string($dbconn, $_POST['zip']);
	$lease = mysqli_real_escape_string($dbconn, $_POST['lease']);
	$renewal = mysqli_real_escape_string($dbconn, $_POST['renewal']);
	$sub_date = mysqli_real_escape_string($dbconn, $_POST['sub_date']);//not passed yet
	$scott_scholar = mysqli_real_escape_string($dbconn, $_POST['scott_scholar']);
	$desired_roommate1 = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['desired_roommate1']));
	$desired_roommate2 = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['desired_roommate2']));
	$desired_roommate3 = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['desired_roommate3']));
	$desired_roommate_ph1 = mysqli_real_escape_string($dbconn, $_POST['desired_roommate_ph1']);
	$desired_roommate_ph2 = mysqli_real_escape_string($dbconn, $_POST['desired_roommate_ph2']);
	$desired_roommate_ph3 = mysqli_real_escape_string($dbconn, $_POST['desired_roommate_ph3']);
	$grade_lvl = mysqli_real_escape_string($dbconn, $_POST['grade_lvl']);
	$enrolled_college = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['enrolled_college']));
	$enrolled_department = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['enrolled_department']));
	$cleanliness = mysqli_real_escape_string($dbconn, $_POST['cleanliness']);
	$noise = mysqli_real_escape_string($dbconn, $_POST['noise']);
	$guest_sleeping = mysqli_real_escape_string($dbconn, $_POST['guest_sleeping']);
	$share_belongings = mysqli_real_escape_string($dbconn, $_POST['share_belongings']);
	$bed_time = mysqli_real_escape_string($dbconn, $_POST['bed_time']);
	$wakeup_time = mysqli_real_escape_string($dbconn, $_POST['wakeup_time']);
	$gathering = mysqli_real_escape_string($dbconn, $_POST['gathering']);
	$drink_alchohol = mysqli_real_escape_string($dbconn, $_POST['drink_alchohol']);
	$others_drink = mysqli_real_escape_string($dbconn, $_POST['others_drink']);
	$smoking = mysqli_real_escape_string($dbconn, $_POST['smoking']);
	$others_smoking = mysqli_real_escape_string($dbconn, $_POST['others_smoking']);
	$noise_rating = mysqli_real_escape_string($dbconn, $_POST['noise_rating']);
	$cleanliness_rating = mysqli_real_escape_string($dbconn, $_POST['cleanliness_rating']);
	$lifestyle_rating = mysqli_real_escape_string($dbconn, $_POST['lifestyle_rating']);
	$age_rating = mysqli_real_escape_string($dbconn, $_POST['age_rating']);
	$major_rating = mysqli_real_escape_string($dbconn, $_POST['major_rating']);
	$guest_rating = mysqli_real_escape_string($dbconn, $_POST['guest_rating']);
	$comments = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['comments']));
	//$comments_resolved = mysqli_real_escape_string($dbconn, $_POST['comments_resolved']);
	$req_room_num = mysqli_real_escape_string($dbconn, $_POST['req_room_num']);
	$req_bedroom_letter = mysqli_real_escape_string($dbconn, $_POST['req_bedroom_letter']);
	//$age = mysqli_real_escape_string($dbconn, $_POST['age']);
		
// prep for req_build_id
$req_build_name = mysqli_real_escape_string($dbconn, $_POST['req_build_name']); 
$req_build_letter = mysqli_real_escape_string($dbconn, $_POST['req_build_letter']); 
// find corresponding build_id from db
$BUILD_ID = "SELECT build_id FROM building WHERE building_name ='" . $req_build_name. "'AND building_letter ='". $req_build_letter . "';";//new
$result_9 = mysqli_query($dbconn, $BUILD_ID);
while($build_id_tempp = mysqli_fetch_assoc($result_9))            {
	foreach($build_id_tempp as $build_idd)
	{
		if(isset($build_idd))
		{
			$req_build_id = mysqli_real_escape_string($dbconn, $build_idd); // req_building_name + req_building_letter = req_build_id (using sql)
		}
	}
}
//$sub_date =date(mm "/" dd "/" y)
//$_age = floor( time() - strtotime('1986-09-16')) / 31556926);
	 $sub_date= date("m/d/Y") ;

	$sql="INSERT INTO students (student_id, group_id, room_num, build_id, first_name, last_name, gender, birthdate, cell_phone, home_phone, email, age, address, city, state, zip, lease, renewal, sub_date, scott_scholar, desired_roommate1, desired_roommate2, desired_roommate3, desired_roommate1_ph, desired_roommate2_ph, desired_roommate3_ph, grade_lvl, enrolled_college, enrolled_department, cleanliness, noise, guest_sleeping, share_belongings, bed_time, wakeup_time, gathering, drink_alchohol, others_drink, smoking, others_smoking, noise_rating, cleanliness_rating, lifestyle_rating, age_rating, major_rating, guest_rating, comments, comments_resolved, req_room_num, req_bedroom_letter, req_build_id) VALUES ('$student_id', 0, 0, 0, '$first_name', '$last_name', '$gender', '$birthdate', '$cell_phone', '$home_phone', '$email', 0, '$address1', '$city', '$state', '$zip', '$lease', '$renewal', '$sub_date', '$scott_scholar', '$desired_roommate1', '$desired_roommate2', '$desired_roommate3', '$desired_roommate_ph1', '$desired_roommate_ph2', '$desired_roommate_ph3', '$grade_lvl', '$enrolled_college', '$enrolled_department', '$cleanliness', '$noise', '$guest_sleeping', '$share_belongings', '$bed_time', '$wakeup_time', '$gathering', '$drink_alchohol', '$others_drink', '$smoking', '$others_smoking',  '$noise_rating', '$cleanliness_rating', '$lifestyle_rating',  '$age_rating', '$major_rating', '$guest_rating', '$comments', 0, '$req_room_num', '$req_bedroom_letter', '$req_build_id')";

	$valid = $valid + validate_string($first_name);
	$valid = $valid + validate_string($last_name);
	$valid = $valid + validate_string($address1);
	$valid = $valid + validate_string($address2);
	$valid = $valid + validate_string($city);
	$valid = $valid + validate_number($zip);
	$valid = $valid + validate_string($desired_roommate1);
	$valid = $valid + validate_string($desired_roommate2);
	$valid = $valid + validate_string($desired_roommate3);
	$valid = $valid + validate_number($desired_roommate_ph1);
	$valid = $valid + validate_string($comments);
	$valid = $valid + validate_number($desired_roommate_ph2);
	$valid = $valid + validate_number($desired_roommate_ph3);

		echo $sql;
	
	if ($valid == 13)
	{
		$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

print<<<END
<script>
window.location="../index.php";
//		window.location="../index.php?validate_string='Student added sucessfully!'";
	
</script>
END;
	}
	else
	{
print<<<END
<script>
window.location="../index.php";
//			window.location="../studentForm.php?validate_string='Campus added sucessfully!'";

</script>
END;
	}

	function validate_string($string)
	{
		if( isset($string) && $string != null && $string != '')
		{
			return 1;
		}
	}
	function validate_number($value)
	{
		if( isset($number) && $number != null && $number != '' && is_numeric($number))
		{
			return 1;
		}
	}

	//$valid = $valid + validate_number($gender);
	//$valid = $valid + validate_string($birthdate);
	//$valid = $valid + validate_number($cell_phone);
	//$valid = $valid + validate_number($home_phone);
	//$valid = $valid + validate_string($email);
	//$valid = $valid + validate_number($age);
	//$valid = $valid + validate_string($state);
	//$valid = $valid + validate_number($lease);
	//$valid = $valid + validate_number($renewal);   // add to form
	//$valid = $valid + validate_string($sub_date);
	//$valid = $valid + validate_number($scott_scholar);
	//$valid = $valid + validate_number($student_id);
	//$valid = $valid + validate_number($group_id);
	//$valid = $valid + validate_number($room_num); //edit form to drop down
	//$valid = $valid + validate_number($build_id); //edit form to drop down
	//$valid = $valid + validate_number($grade_lvl);
	//$valid = $valid + validate_string($enrolled_college);
	//$valid = $valid + validate_string($enrolled_department);
	//$valid = $valid + validate_number($cleanliness);
	//$valid = $valid + validate_number($noise);
	//$valid = $valid + validate_number($guest_sleeping);
	//$valid = $valid + validate_number($share_belongings);
	//$valid = $valid + validate_number($bed_time);
	//$valid = $valid + validate_number($wakeup_time);
	//$valid = $valid + validate_number($gathering);
	//$valid = $valid + validate_number($drink_alchohol);
	//$valid = $valid + validate_number($other_drink);
	//$valid = $valid + validate_number($smoking);
	//$valid = $valid + validate_number($others_smoking);
	//$valid = $valid + validate_number($noise_rating);
	//$valid = $valid + validate_number($cleanliness_rating);
	//$valid = $valid + validate_number($lifestyle_rating);
	//$valid = $valid + validate_number($age_rating);
	//$valid = $valid + validate_number($major_rating);
	//$valid = $valid + validate_number($guest_rating);
	//$valid = $valid + validate_number($comments_resolved);
	//$valid = $valid + validate_number($req_room_num);
	//$valid = $valid + validate_number($req_bedroom_letter);

?> 
