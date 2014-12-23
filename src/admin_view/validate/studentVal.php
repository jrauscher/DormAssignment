<?php
	include ('../includes/svrConnect.php');
	
/**recieve POST variables from student form, replace spaces with "_", escape strings to avoid SQL injections */	
// escape variables for security
	$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */
	$student_id = mysqli_real_escape_string($dbconn, $_POST['student_id']);/**<  Gets the student from the student registration form*/ 
	//$group_id = mysqli_real_escape_string($dbconn, $_POST['group_id']);// not passed yet
	//$room_num = mysqli_real_escape_string($dbconn, $_POST['room_num']);// not passed yet
	//$build_id = mysqli_real_escape_string($dbconn, $_POST['build_id']);// not passed yet
	$first_name = mysqli_real_escape_string($dbconn, $_POST['first_name']);/**<  Gets the student from the student registration form*/ 
	$last_name = mysqli_real_escape_string($dbconn, $_POST['last_name']);/**<  Gets the student from the student registration form*/ 
	$gender = mysqli_real_escape_string($dbconn, $_POST['gender']);/**<  Gets the student from the student registration form*/ 
	$birthdate = mysqli_real_escape_string($dbconn, $_POST['birthdate']);/**<  Gets the student from the student registration form*/ 
	$cell_phone = mysqli_real_escape_string($dbconn, $_POST['cell_phone']);/**<  Gets the student from the student registration form*/ 
	$home_phone = mysqli_real_escape_string($dbconn, $_POST['home_phone']);/**<  Gets the student from the student registration form*/ 
	$email = mysqli_real_escape_string($dbconn, $_POST['email']);/**<  Gets the student from the student registration form*/ 
	//$age = mysqli_real_escape_string($dbconn, $_POST['age']); // compute in this file
	$address1 = mysqli_real_escape_string($dbconn, $_POST['address1']);/**<  Gets the student from the student registration form*/ 
	$address2 = mysqli_real_escape_string($dbconn, $_POST['address2']);/**<  Gets the student from the student registration form*/ 
	$city = mysqli_real_escape_string($dbconn, $_POST['city']);/**<  Gets the student from the student registration form*/ 
	$state = mysqli_real_escape_string($dbconn, $_POST['state']);/**<  Gets the student from the student registration form*/ 
	$zip = mysqli_real_escape_string($dbconn, $_POST['zip']);/**<  Gets the student from the student registration form*/ 
	$lease = mysqli_real_escape_string($dbconn, $_POST['lease']);/**<  Gets the student from the student registration form*/ 
	$renewal = mysqli_real_escape_string($dbconn, $_POST['renewal']);/**<  Gets the student from the student registration form*/ 
	$sub_date = mysqli_real_escape_string($dbconn, $_POST['sub_date']);/**<  Gets the student from the student registration form*///not passed yet
	$scott_scholar = mysqli_real_escape_string($dbconn, $_POST['scott_scholar']);/**<  Gets the student from the student registration form*/ 
	$desired_roommate1 = mysqli_real_escape_string($dbconn, $_POST['desired_roommate1']);/**<  Gets the student from the student registration form*/ 
	$desired_roommate2 = mysqli_real_escape_string($dbconn, $_POST['desired_roommate2']);/**<  Gets the student from the student registration form*/ 
	$desired_roommate3 = mysqli_real_escape_string($dbconn, $_POST['desired_roommate3']);/**<  Gets the student from the student registration form*/ 
	$desired_roommate1_ph = mysqli_real_escape_string($dbconn, $_POST['desired_roommate_ph1']);/**<  Gets the student from the student registration form*/ 
	$desired_roommate2_ph = mysqli_real_escape_string($dbconn, $_POST['desired_roommate_ph2']);/**<  Gets the student from the student registration form*/ 
	$desired_roommate3_ph = mysqli_real_escape_string($dbconn, $_POST['desired_roommate_ph3']);/**<  Gets the student from the student registration form*/ 
	$grade_lvl = mysqli_real_escape_string($dbconn, $_POST['grade_lvl']);/**<  Gets the student from the student registration form*/ 
	$enrolled_college = mysqli_real_escape_string($dbconn, $_POST['enrolled_college']);/**<  Gets the student from the student registration form*/ 
	$enrolled_department = mysqli_real_escape_string($dbconn, $_POST['enrolled_department']);/**<  Gets the student from the student registration form*/ 
	$cleanliness = mysqli_real_escape_string($dbconn, $_POST['cleanliness']);/**<  Gets the student from the student registration form*/ 
	$noise = mysqli_real_escape_string($dbconn, $_POST['noise']);/**<  Gets the student from the student registration form*/ 
	$guest_sleeping = mysqli_real_escape_string($dbconn, $_POST['guest_sleeping']);/**<  Gets the student from the student registration form*/ 
	$share_belongings = mysqli_real_escape_string($dbconn, $_POST['share_belongings']);/**<  Gets the student from the student registration form*/ 
	$bed_time = mysqli_real_escape_string($dbconn, $_POST['bed_time']);/**<  Gets the student from the student registration form*/ 
	$wakeup_time = mysqli_real_escape_string($dbconn, $_POST['wakeup_time']);/**<  Gets the student from the student registration form*/ 
	$gathering = mysqli_real_escape_string($dbconn, $_POST['gathering']);/**<  Gets the student from the student registration form*/ 
	$drink_alchohol = mysqli_real_escape_string($dbconn, $_POST['drink_alchohol']);/**<  Gets the student from the student registration form*/ 
	$others_drink = mysqli_real_escape_string($dbconn, $_POST['others_drink']);/**<  Gets the student from the student registration form*/ 
	$smoking = mysqli_real_escape_string($dbconn, $_POST['smoking']);/**<  Gets the student from the student registration form*/ 
	$others_smoking = mysqli_real_escape_string($dbconn, $_POST['others_smoking']);/**<  Gets the student from the student registration form*/ 
	$noise_rating = mysqli_real_escape_string($dbconn, $_POST['noise_rating']);/**<  Gets the student from the student registration form*/ 
	$cleanliness_rating = mysqli_real_escape_string($dbconn, $_POST['cleanliness_rating']);/**<  Gets the student from the student registration form*/ 
	$lifestyle_rating = mysqli_real_escape_string($dbconn, $_POST['lifestyle_rating']);/**<  Gets the student from the student registration form*/ 
	$age_rating = mysqli_real_escape_string($dbconn, $_POST['age_rating']);/**<  Gets the student from the student registration form*/ 
	$major_rating = mysqli_real_escape_string($dbconn, $_POST['major_rating']);/**<  Gets the student from the student registration form*/ 
	$guest_rating = mysqli_real_escape_string($dbconn, $_POST['guest_rating']);/**<  Gets the student from the student registration form*/ 
	$comments = mysqli_real_escape_string($dbconn, $_POST['comments']);/**<  Gets the student from the student registration form*/ 
	//$comments_resolved = mysqli_real_escape_string($dbconn, $_POST['comments_resolved']);
	$req_room_num = mysqli_real_escape_string($dbconn, $_POST['req_room_num']);/**<  Gets the student from the student registration form*/
	$req_bedroom_letter = mysqli_real_escape_string($dbconn, $_POST['req_bedroom_letter']);/**<  Gets the student from the student registration form*/
	
// prep for req_build_id
$req_building_name = mysqli_real_escape_string($dbconn, $_POST['req_build_name']);/**<  Gets the student from the student registration form*/ 
$_req_building_letter = mysqli_real_escape_string($dbconn, $_POST['req_build_letter']);/**<  Gets the student from the student registration form*/ 
// find corresponding build_id from db
$BUILD_ID = "SELECT build_id FROM building WHERE building_name ='" . $COMPLEX . "'AND building_letter ='". $std_build2 . "';";/**< SQL statement to select building id based on complex name and building letter */
$result_9 = mysqli_query($dbconn, $BUILD_ID);
while($build_id_tempp = mysqli_fetch_assoc($result_9))            {
	foreach($build_id_tempp as $build_idd)
	{
	}
}
	$req_build_id = mysqli_real_escape_string($dbconn, $build_idd); // req_building_name + req_building_letter = req_build_id (using sql)

//  		clear until here

	$sql="INSERT INTO students (student_id, group_id, room_num, build_id, first_name, last_name, gender, birthdate, cell_phone, home_phone, email, age, address, city, state, zip, lease, renewal, sub_date, scott_scholar, desired_roommate1, desired_roommate2, desired_roommate3, desired_roommate1_ph, desired_roommate2_ph, desired_roommate3_ph, grade_lvl, enrolled_college, enrolled_department, cleanliness, noise, guest_sleeping, share_belongings, bed_time, wakeup_time, gathering, drink_alchohol, others_drink, smoking, others_smoking, noise_rating, cleanliness_rating, lifestyle_rating, age_rating, major_rating, guest_rating, comments, comments_resolved, req_room_num, req_bedroom_letter, req_build_id) VALUES ($student_id,  $group_id,  $room_num,  $build_id,  $first_name,  $last_name,  $gender,  $birthdate,  $cell_phone,  $home_phone,  $email,  $age,  $address,  $city,  $state,  $zip,  $lease,  $renewal,  $sub_date,  $scott_scholar,  $desired_roommate1,  $desired_roommate2,  $desired_roommate3,  $desired_roommate1_ph,  $desired_roommate2_ph,  $desired_roommate3_ph,  $grade_lvl,  $enrolled_college,  $enrolled_department,  $cleanliness,  $noise,  $guest_sleeping,  $share_belongings,  $bed_time,  $wakeup_time,  $gathering,  $drink_alchohol,  $others_drink,  $smoking,  $others_smoking,  $noise_rating,  $cleanliness_rating,  $lifestyle_rating,  $age_rating,  $major_rating,  $guest_rating,  $comments,  $comments_resolved, $req_room_num ,$req_bedroom_letter,$req_build_id)";/**< SQL query to insert variables from     student form into the database */

	$valid = $valid + validate_string($first_name);
	$valid = $valid + validate_string($last_name);
	$valid = $valid + validate_string($address);
	$valid = $valid + validate_string($city);
	$valid = $valid + validate_number($zip);
	$valid = $valid + validate_string($desired_roommate1);
	$valid = $valid + validate_string($desired_roommate2);
	$valid = $valid + validate_string($desired_roommate3);
	$valid = $valid + validate_number($desired_roommate1_ph);
	$valid = $valid + validate_number($desired_roommate2_ph);
	$valid = $valid + validate_number($desired_roommate3_ph);
	$valid = $valid + validate_string($comments);

	if ($valid == 12)
	{
		$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

		print<<<END
		<script>
//		window.location="index.php";
//		window.location="../index.php?validate_string='Student added sucessfully!'";
	
		</script>
		END;
	}
	else
	{
		print<<<END
		<script>
//		window.location="index.php";
//			window.location="../studentForm.php?validate_string='Campus added sucessfully!'";

		</script>
		END;
	}
/** check if input is string, can  NOT be empty */
	function validate_string($string)
	{
		if( isset($string) && $string != null && $string != '')
		{
			return 1;
		}
	}
/** check if input is number, can NOT be empty */	
function validate_number($value)
	{
		if( isset($number) && $number != null && $number != '' && is_numeric($number))
		{
			return 1i;
		}
	}
/* back up validations from form, to uncomment a variable when needed */	
//$valid = $valid + validate_string($state);
	//$valid = $valid + validate_number($lease);
	//$valid = $valid + validate_number($renewal);   // add to form
	//$valid = $valid + validate_string($sub_date);
	//$valid = $valid + validate_number($scott_scholar);
	//$valid = $valid + validate_number($student_id);
	//$valid = $valid + validate_number($group_id);
	//	$valid = $valid + validate_number($room_num); //edit form to drop down
	//	$valid = $valid + validate_number($build_id); //edit form to drop down
	//$valid = $valid + validate_number($gender);
	//$valid = $valid + validate_string($birthdate);
	//$valid = $valid + validate_number($cell_phone);
	//$valid = $valid + validate_number($home_phone);
	//$valid = $valid + validate_string($email);
	//$valid = $valid + validate_number($age);
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
