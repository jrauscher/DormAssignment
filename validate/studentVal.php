<?php
$con=mysqli_connect("localhost","root","root","UNODB");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// escape variables for security
//$NUID = mysqli_real_escape_string($con, $_POST['NUID']);
//$email = mysqli_real_escape_string($con, $_POST['email']);
//$complex = mysqli_real_escape_string($con, $_POST['complex']);
$valid = 0;

$student_id = mysqli_real_escape_string($con, $_POST['student_id']);
$group_id = mysqli_real_escape_string($con, $_POST['group_id']);
$room_num = mysqli_real_escape_string($con, $_POST['room_num']);
$build_id = mysqli_real_escape_string($con, $_POST['build_id']);
$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
$last_name = mysqli_real_escape_string($con, $_POST['last_name']);
$gender = mysqli_real_escape_string($con, $_POST['gender']);
$birthdate = mysqli_real_escape_string($con, $_POST['birthdate']);
$cell_phone = mysqli_real_escape_string($con, $_POST['cellphone']);
$home_phone = mysqli_real_escape_string($con, $_POST['home_phone']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$age = mysqli_real_escape_string($con, $_POST['age']);
$address = mysqli_real_escape_string($con, $_POST['address']);
$city = mysqli_real_escape_string($con, $_POST['state']);
$state = mysqli_real_escape_string($con, $_POST['state']);
$zip = mysqli_real_escape_string($con, $_POST['zip']);
$lease = mysqli_real_escape_string($con, $_POST['lease']);
$renewal = mysqli_real_escape_string($con, $_POST['renewal']);
$sub_date = mysqli_real_escape_string($con, $_POST['sub_date']);
$scott_scholar = mysqli_real_escape_string($con, $_POST['scott_scholar']);
$desired_roommate1 = mysqli_real_escape_string($con, $_POST['desired_roommate1']);
$desired_roommate2 = mysqli_real_escape_string($con, $_POST['desired_roommate2']);
$desired_roommate3 = mysqli_real_escape_string($con, $_POST['desired_roommate3']);
$desired_roommate1_ph = mysqli_real_escape_string($con, $_POST['desired_roommate_ph1']);
$desired_roommate2_ph = mysqli_real_escape_string($con, $_POST['desired_roommate_ph2']);
$desired_roommate3_ph = mysqli_real_escape_string($con, $_POST['desired_roommate_ph3']);
$grade_lvl = mysqli_real_escape_string($con, $_POST['grade_lvl']);
$enrolled_college = mysqli_real_escape_string($con, $_POST['enrolled_college']);
$enrolled_department = mysqli_real_escape_string($con, $_POST['enrolled_department']);
$cleanliness = mysqli_real_escape_string($con, $_POST['cleanliness']);
$noise = mysqli_real_escape_string($con, $_POST['noise']);
$guest_sleeping = mysqli_real_escape_string($con, $_POST['guest_sleeping']);
$share_belongings = mysqli_real_escape_string($con, $_POST['share_belingings']);
$bed_time = mysqli_real_escape_string($con, $_POST['bed_time']);
$wakeup_time = mysqli_real_escape_string($con, $_POST['wakeup_time']);
$gathering = mysqli_real_escape_string($con, $_POST['gathering']);
$drink_alchohol = mysqli_real_escape_string($con, $_POST['drink_alcohol']);
$others_drink = mysqli_real_escape_string($con, $_POST['other_drink']);
$smoking = mysqli_real_escape_string($con, $_POST['smoking']);
$others_smoking = mysqli_real_escape_string($con, $_POST['other_smoking']);
$noise_rateing = mysqli_real_escape_string($con, $_POST['noise_rateing']);
$cleanliness_rateing = mysqli_real_escape_string($con, $_POST['cleanliness']);
$lifestyle_rateing = mysqli_real_escape_string($con, $_POST['lifestyle_rateing']);
$age_rateing = mysqli_real_escape_string($con, $_POST['age_rateing']);
$major_rateing = mysqli_real_escape_string($con, $_POST['major_rateing']);
$guest_rateing = mysqli_real_escape_string($con, $_POST['guest_rateing']);
$comments = mysqli_real_escape_string($con, $_POST['comments']);
$comments_resolved = mysqli_real_escape_string($con, $_POST['comments_resolved']);
$req_room_num = mysqli_real_escape_string($con, $_POST['req_room_num']);

$sql="INSERT INTO students (student_id, group_id, room_num, build_id, first_name, last_name, gender, birthdate, cell_phone, home_phone, email, age, address, city, state, zip, lease, renewal, sub_date, scott_scholar, desired_roommate1, desired_roommate2, desired_roommate3, desired_roommate1_ph, desired_roommate2_ph, desired_roommate3_ph, grade_lvl, enrolled_college, enrolled_department, cleanliness, noise, guest_sleeping, share_belongings, bed_time, wakeup_time, gathering, drink_alchohol, others_drink, smoking, others_smoking, noise_rateing, cleanliness_rateing, lifestyle_rateing, age_rateing, major_rateing, guest_rateing, comments, comments_resolved, req_room_num, req_bedroom_letter) VALUES ($student_id,  $group_id,  $room_num,  $build_id,  $first_name,  $last_name,  $gender,  $birthdate,  $cell_phone,  $home_phone,  $email,  $age,  $address,  $city,  $state,  $zip,  $lease,  $renewal,  $sub_date,  $scott_scholar,  $desired_roommate1,  $desired_roommate2,  $desired_roommate3,  $desired_roommate1_ph,  $desired_roommate2_ph,  $desired_roommate3_ph,  $grade_lvl,  $enrolled_college,  $enrolled_department,  $cleanliness,  $noise,  $guest_sleeping,  $share_belongings,  $bed_time,  $wakeup_time,  $gathering,  $drink_alchohol,  $others_drink,  $smoking,  $others_smoking,  $noise_rateing,  $cleanliness_rateing,  $lifestyle_rateing,  $age_rateing,  $major_rateing,  $guest_rateing,  $comments,  $comments_resolved, '0' ,'0' )";

//$valid = $valid + validate_numbers($student_id);
//$valid = $valid + validate_numbers($group_id);
$valid = $valid + validate_numbers($room_num); //edit form to drop down
$valid = $valid + validate_numbers($build_id); //edit form to drop down
$valid = $valid + validate($first_name);
$valid = $valid + validate($last_name);
//$valid = $valid + validate_numbers($gender);
//$valid = $valid + validate($birthdate);
//$valid = $valid + validate_numbers($cell_phone);
//$valid = $valid + validate_numbers($home_phone);
//$valid = $valid + validate($email);
//$valid = $valid + validate_numbers($age);
$valid = $valid + validate($address);
$valid = $valid + validate($city);
//$valid = $valid + validate($state);
$valid = $valid + validate_numbers($zip);
//$valid = $valid + validate_numbers($lease);
//$valid = $valid + validate_numbers($renewal);   // add to form
//$valid = $valid + validate($sub_date);
//$valid = $valid + validate_numbers($scott_scholar);
$valid = $valid + validate($desired_roommate1);
$valid = $valid + validate($desired_roommate2);
$valid = $valid + validate($desired_roommate3);
$valid = $valid + validate_numbers($desired_roommate1_ph);
$valid = $valid + validate_numbers($desired_roommate2_ph);
$valid = $valid + validate_numbers($desired_roommate3_ph);
//$valid = $valid + validate_numbers($grade_lvl);
$valid = $valid + validate($enrolled_college);
$valid = $valid + validate($enrolled_department);
//$valid = $valid + validate_numbers($cleanliness);
//$valid = $valid + validate_numbers($noise);
//$valid = $valid + validate_numbers($guest_sleeping);
//$valid = $valid + validate_numbers($share_belongings);
//$valid = $valid + validate_numbers($bed_time);
//$valid = $valid + validate_numbers($wakeup_time);
//$valid = $valid + validate_numbers($gathering);
//$valid = $valid + validate_numbers($drink_alchohol);
//$valid = $valid + validate_numbers($other_drink);
//$valid = $valid + validate_numbers($smoking);
//$valid = $valid + validate_numbers($others_smoking);
//$valid = $valid + validate_numbers($noise_rateing);
//$valid = $valid + validate_numbers($cleanliness_rateing);
//$valid = $valid + validate_numbers($lifestyle_rateing);
//$valid = $valid + validate_numbers($age_rateing);
//$valid = $valid + validate_numbers($major_rateing);
//$valid = $valid + validate_numbers($guest_rateing);
$valid = $valid + validate($comments);
//$valid = $valid + validate_numbers($comments_resolved);
//$valid = $valid + validate_numbers($req_room_num);
//$valid = $valid + validate_numbers($req_bedroom_letter);



if ($valid == 3){
$result = mysqli_query($con, $sql) or die ('Error ' . mysqli_error($con));

print<<<END
<script>
window.location="../settings.php";
</script>
END;
}
else{
print<<<END
<script>
window.location="../failed.php";
</script>
END;
}

function $validate($string)
{
	if( isset($string) && $string != null && $string != '')
	{
		return 1;
	}
}
function $validate_numbers ($value)
{
	if( isset($number) && $number != null && $number != '' && is_numeric($number))
	{
		return 1;
	}
}
?> 
