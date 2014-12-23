<?php
	include ('../../includes/svrConnect.php');
	$was_errors = false;
	$errors = array();
	// escape variables for security
	$valid = 0;
	//str_replace(' ', '_', $name);

/**recieve POST variables from student form, replace spaces with "_", escape strings to avoid SQL injections */
	$student_id = mysqli_real_escape_string($dbconn, $_POST['student_id']); /**< Gets the student id from the student registration form */
	$first_name = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['first_name'])); /**< Gets the students first name from the student registration form */
	$last_name = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['last_name'])); /**< Gets the students last name from the student registration form */
	$gender = mysqli_real_escape_string($dbconn, $_POST['gender']); /**< Gets the student gender from the student registration form */
	$birthdate = mysqli_real_escape_string($dbconn, $_POST['birthdate']); /**< Gets the student birthday from the student registration form */
	$cell_phone = mysqli_real_escape_string($dbconn, $_POST['cell_phone']);/**<  Gets the student cell phonefrom the student registration form*/
	$home_phone = mysqli_real_escape_string($dbconn, $_POST['home_phone']);/**<  Gets the student home phone from the student registration form*/
	$email = str_replace('@', '_',mysqli_real_escape_string($dbconn, $_POST['email']));/**<  Gets the student email from the student registration form*/
	$address1 = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['address1']));/**<  Gets the student address line 1 from the student registration form*/
	$address2 = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['address2']));/**<  Gets the student address line 2 from the student registration form*/
	$city = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['city']));/**<  Gets the student city from the student registration form*/
	$state = mysqli_real_escape_string($dbconn, $_POST['state']);/**<  Gets the student state from the student registration form*/
	$zip = mysqli_real_escape_string($dbconn, $_POST['zip']);/**<  Gets the student zip from the student registration form*/
	$lease = mysqli_real_escape_string($dbconn, $_POST['lease']);/**<  Gets the student lease from the student registration form*/
	$renewal = mysqli_real_escape_string($dbconn, $_POST['renewal']);/**<  Gets the student renewal value from the student registration form*/
	$sub_date = mysqli_real_escape_string($dbconn, $_POST['sub_date']);/**<  Gets the student submission date value from the student registration form*/
	$scott_scholar = mysqli_real_escape_string($dbconn, $_POST['scott_scholar']);/**<  Gets the student schott scholar value from the student registration form*/
	$desired_roommate1 = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['desired_roommate1']));/**<  Gets the student desired roomate 1 from the student registration form*/
	$desired_roommate2 = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['desired_roommate2']));/**<  Gets the student desired roomate 2 from the student registration form*/
	$desired_roommate3 = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['desired_roommate3']));/**<  Gets the student desired roomate 3from the student registration form*/
	$desired_roommate_ph1 = mysqli_real_escape_string($dbconn, $_POST['desired_roommate_ph1']);/**<  Gets the student desired roomate 1 phone number from the student registration form*/
	$desired_roommate_ph2 = mysqli_real_escape_string($dbconn, $_POST['desired_roommate_ph2']);/**<  Gets the student desireed roomate 2 phone numer from the student registration form*/
	$desired_roommate_ph3 = mysqli_real_escape_string($dbconn, $_POST['desired_roommate_ph3']);/**<  Gets the student desired roomate 3 phone number from the student registration form*/
	$grade_lvl = mysqli_real_escape_string($dbconn, $_POST['grade_lvl']);/**<  Gets the student grade level from the student registration form*/
	$enrolled_college = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['enrolled_college']));/**<  Gets the student college enrollment from the student registration form*/
	$enrolled_department = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['enrolled_department']));/**<  Gets the student department enrollment from the student registration form*/
	$cleanliness = mysqli_real_escape_string($dbconn, $_POST['cleanliness']);/**<  Gets the student cleanliness preference value from the student registration form*/
	$noise = mysqli_real_escape_string($dbconn, $_POST['noise']);/**<  Gets the student noise preference value from the student registration form*/
	$guest_sleeping = mysqli_real_escape_string($dbconn, $_POST['guest_sleeping']);/**<  Gets the student guest_sleeping preference value  from the student registration form*/
	$share_belongings = mysqli_real_escape_string($dbconn, $_POST['share_belongings']);/**<  Gets the student share belongings preference value from the student registration form*/
	$bed_time = mysqli_real_escape_string($dbconn, $_POST['bed_time']);/**<  Gets the student bed time preference value from the student registration form*/
	$wakeup_time = mysqli_real_escape_string($dbconn, $_POST['wakeup_time']);/**<  Gets the student wakeup time preference value from the student registration form*/
	$gathering = mysqli_real_escape_string($dbconn, $_POST['gathering']);/**<  Gets the student gathering preference value from the student registration form*/
	$drink_alchohol = mysqli_real_escape_string($dbconn, $_POST['drink_alchohol']);/**<  Gets the student alchohol drinking preference value from the student registration form*/
	$others_drink = mysqli_real_escape_string($dbconn, $_POST['others_drink']);/**<  Gets the student others drink preference value from the student registration form*/
	$smoking = mysqli_real_escape_string($dbconn, $_POST['smoking']);/**<  Gets the student smoking preference value from the student registration form*/
	$others_smoking = mysqli_real_escape_string($dbconn, $_POST['others_smoking']);/**<  Gets the student others smoking preference value from the student registration form*/
	$noise_rating = mysqli_real_escape_string($dbconn, $_POST['noise_rating']);/**<  Gets the student noise rating from the student registration form*/
	$cleanliness_rating = mysqli_real_escape_string($dbconn, $_POST['cleanliness_rating']);/**<  Gets the student cleanliness rating from the student registration form*/
	$lifestyle_rating = mysqli_real_escape_string($dbconn, $_POST['lifestyle_rating']);/**<  Gets the student lifestyle rating from the student registration form*/
	$age_rating = mysqli_real_escape_string($dbconn, $_POST['age_rating']);/**<  Gets the student age rating from the student registration form*/
	$major_rating = mysqli_real_escape_string($dbconn, $_POST['major_rating']);/**<  Gets the student major rating from the student registration form*/
	$guest_rating = mysqli_real_escape_string($dbconn, $_POST['guest_rating']);/**<  Gets the student guest rating from the student registration form*/
	$comments = str_replace(' ', '_',mysqli_real_escape_string($dbconn, $_POST['comments']));/**<  Gets the student comments rating from the student registration form*/
	$req_room_num = mysqli_real_escape_string($dbconn, $_POST['req_room_num']);/**<  Gets the student requested room number from the student registration form*/
	$req_bedroom_letter = mysqli_real_escape_string($dbconn, $_POST['req_bedroom_letter']); /**<  Gets the student requested bedroom letter from the student registration form*/
	//$age = mysqli_real_escape_string($dbconn, $_POST['age']);
		
// prep for req_build_id
$req_build_name = mysqli_real_escape_string($dbconn, $_POST['req_build_name']);/**<  Gets the student requested building name from the student registration form*/ 
$req_build_letter = mysqli_real_escape_string($dbconn, $_POST['req_build_letter']);/**<  Gets the student requested building letter from the student registration form*/ 
// find corresponding build_id from db
$BUILD_ID = "SELECT build_id FROM building WHERE building_name ='" . $req_build_name. "'AND building_letter ='". $req_build_letter . "'";/**< SQL statement to get the building id of requested complex name and building letter*/
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

	$sql="INSERT INTO students (student_id, group_id, room_num, build_id, first_name, last_name, gender, birthdate, cell_phone, home_phone, email, age, address, city, state, zip, lease, renewal, sub_date, scott_scholar, desired_roommate1, desired_roommate2, desired_roommate3, desired_roommate1_ph, desired_roommate2_ph, desired_roommate3_ph, grade_lvl, enrolled_college, enrolled_department, cleanliness, noise, guest_sleeping, share_belongings, bed_time, wakeup_time, gathering, drink_alchohol, others_drink, smoking, others_smoking, noise_rating, cleanliness_rating, lifestyle_rating, age_rating, major_rating, guest_rating, comments, comments_resolved, req_room_num, req_bedroom_letter, req_build_id) VALUES ('$student_id', 0, 0, 0, '$first_name', '$last_name', '$gender', '$birthdate', '$cell_phone', '$home_phone', '$email', 0, '$address1', '$city', '$state', '$zip', '$lease', '$renewal', '$sub_date', '$scott_scholar', '$desired_roommate1', '$desired_roommate2', '$desired_roommate3', '$desired_roommate_ph1', '$desired_roommate_ph2', '$desired_roommate_ph3', '$grade_lvl', '$enrolled_college', '$enrolled_department', '$cleanliness', '$noise', '$guest_sleeping', '$share_belongings', '$bed_time', '$wakeup_time', '$gathering', '$drink_alchohol', '$others_drink', '$smoking', '$others_smoking',  '$noise_rating', '$cleanliness_rating', '$lifestyle_rating',  '$age_rating', '$major_rating', '$guest_rating', '$comments', 0, '$req_room_num', '$req_bedroom_letter', '$req_build_id')";/**< SQL query to insert variables from student form into the database */

	$valid_first_name = 0; /**<first name valid check*/
	$valid_last_name = 0;/**<last name valid check */
	$valid_cell_ph = 0;/**< cell_phone valid check*/
	$valid_home_ph = 0;/**< home phone valid check*/
	$valid_address1 = 0;/**< address 1 valid check*/
	$valid_city = 0;/**< city valid check*/
	$valid_zip = 0;/**< zip valid check*/
	$valid = 0;/**< count of valids*/
	/** validate these inputs */
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
// use switch statement
		echo $sql;
	
//	if ($valid == 13)
//	{
//		$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

//print<<<END
//<script>
//window.location="../index.php?approved=yes";
////		window.location="../index.php?validate_string='Student added sucessfully!'";
	
//</script>
//END;
//	}
//	else
//	{
//print<<<END
//<script>
//window.location="../index.php?approved=no";
//			window.location="../studentForm.php?validate_string='Campus added sucessfully!'";

//</script>
//END;
//	}

	/** check if input is string, can  NOT be empty */
	function validate_must_string($string)
	{
		if( isset($string) && $string != null && $string != '')
		{
			return 1;
		}
	}
	/** check if input is number, can NOT be empty */
	function validate_must_number($value)
	{
		if( isset($number) && $number != null && $number != '' && is_numeric($number))
		{
			return 1;
		}
	}
	/** check if input is string, can be empty */
	function validate_string($string)
	{
		if( isset($string) && $string != null && $string != '')
		{
			return 1;
		}
	}
	/** check if input is number, can be empty */
	function validate_number($value)
	{
		if( isset($number) && $number != null && $number != '' && is_numeric($number))
		{
			return 1;
		}
	}

	/* back up validations from form, to uncomment a variable when needed */
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
