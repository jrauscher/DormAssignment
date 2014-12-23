<?php
	include ('../includes/svrConnect.php');

$campus_string =''; /**< All of the campus names. */
$group_string = ''; /**< All of the building names. */
$building_count = 0; /**< The number of buildings. */
$total_room_count =0; /**< The number of rooms. */
$avail_room_count =0; /**< The number of rooms that are not full. */
$user_string = ''; /**< The name of the logged in user. */
$user_completion_count = 0; /**< The number of users that filled out the student form */
$user_needs_email_count = 0; /**< The number of users that still need to be emailed the url for this application. */
$group_arr = array(); /**< Associative array to map the building id to the building name. */
$array_counter=0; /**< This is a counter variable that is used to iterate through a loop. */
$males_count = 0; /**< The number of males in this application. */
$females_count = 0; /**< The number of females in this application. */
$student_gender_var =''; /**< The gender of the logged in user. */
$campus = "SELECT DISTINCT campus FROM building"; /**< SQL query to get all the campuses. */
$building_names = "SELECT DISTINCT building_name FROM building WHERE campus ='"; /**< SQL query to get the different building names from the building table. */
$building_letters = "SELECT building_letter FROM building WHERE build_id ='"; /**< SQL query to get the different building letters. */
$build_idd ="SELECT build_id FROM building WHERE building_name = '"; /**< SQL query to get the building ids. */
$num_roomss = "SELECT num_rooms FROM building WHERE build_id = '"; /**< SQL query to get the number of rooms in a given building. */

$result_user_building_x = mysqli_query($dbconn, "SELECT building_name FROM users"); /**< Holds the result for the query to get the different building names from the users table. */
$result_warning_date = mysqli_query($dbconn, "SELECT warning_date FROM form_settings"); /**< Holds the result for the query to get the date that is set for the warning email from the form_settings table. */
$result_deadline_date = mysqli_query($dbconn, "SELECT deadline_date FROM form_settings"); /**< Holds the result for the query to get the date that is set for the deadline email from the form_settings table. */
$result_user_needs_email = mysqli_query($dbconn, "SELECT needs_email FROM users"); /**< Holds the result for the query to find who still needs to receive an email for a link to this application from the users table. */
$result_user_completion = mysqli_query($dbconn, "SELECT form_completion FROM users"); /**< Holds the result for the query to find who had completed the student form from the users table. */
$result_student_gender = mysqli_query($dbconn, "SELECT gender FROM students"); /**< Holds the result for the query to find the genders from the students table. */

$warning_date = mysqli_fetch_assoc($result_warning_date); /**< Creates an array of the query $result_warning_date. */
$result_campus = mysqli_query($dbconn, $campus . ";"); /**< Holds the result for the query $campus. */
$deadline_date = mysqli_fetch_assoc($result_deadline_date); /**< Creates an array of the query $deadline_date. */

include ('../includes/header.html');

while($campus_name = mysqli_fetch_assoc($result_campus))
{
	foreach ($campus_name as $campus_val)
	{
		$campus_string = $campus_string . ' ' . $campus_val . ',';
		$result_building_names = mysqli_query($dbconn, $building_names . $campus_val . "';");
		while ($building_name = mysqli_fetch_assoc($result_building_names))
		{
			foreach ($building_name as $building_val)
			{
				$group_arr[$building_val] = 0;
				$group_string = $group_string . ' '. $building_val . ',';
				$array_counter = $array_counter + 1; 	
				$result_building_id = mysqli_query($dbconn, $build_idd . $building_val . "';");
				while ($building_id = mysqli_fetch_assoc($result_building_id)) 
				{
					foreach($building_id as $building_id_val)
					{
						$building_letter = mysqli_query($dbconn, $building_letters . $building_id_val . "';");	
						$building_count = $building_count + 1;
						$result_room_num = mysqli_query($dbconn, $num_roomss . $building_id_val . "';"); 
						while ($room_num = mysqli_fetch_assoc($result_room_num)) 
						{
							foreach($room_num as $room_num_val)
							{
								$total_room_count = $total_room_count +  $room_num_val;
							}	
						}
					}
				}
			}
		}
	}
}

$user_completion_count = fetch_count($result_user_completion); /**< The result from the fetch_count function. */
$user_needs_email_count = fetch_count($result_user_needs_email); /**< The result from the fetch_count function. */

/**
* Increments the $group_arr array for each building that is in it.
*/
while ($user_building_x = mysqli_fetch_assoc($result_user_building_x))
{
	foreach($user_building_x as $user_building_value_x)
	{
			if (isset($group_arr[$user_building_value_x]))
			{
				$group_arr[$user_building_value_x] = $group_arr[$user_building_value_x] + 1;
			}
	}
}

/**
*
* Finds the total number of males and females.
*/
while ($student_gender = mysqli_fetch_assoc($result_student_gender))
{
	foreach($student_gender as $student_gender_val)
	{
			
			if($student_gender_val)
			{
				$males_count++;
			}
			else
			{
				$females_count++;
			}
	}
}

$warning_date_value = date_check($warning_date); /**< The result from the date_check function. */
$deadline_date_value = date_check($deadline_date); /**< The result from the date_check function. */

/**
*<pre>
DATE_CHECK: Checks whether or not the given date is set.
TAKES: An array of dates.
RETURNS: The last date within the given date array OR "Not set up".
</pre>
*/
function date_check($X)
{
	if($X)
	{
		foreach($X as $Y){}
	}
	else
	{
		$Y ='Not set up.';
	}
	return $Y;
}
	
/**
*<pre>
FETCH_COUNT: Checks how many elements are in an array.
TAKES: An array.
RETURNS: The number of elements in the array.
</pre>
*/
function fetch_count($X)
{
	$count = 0;
	while ($Y = mysqli_fetch_assoc($X))
	{
		foreach($Y as $Z)
		{	if ($Z)
			{
				$count = $count + 1;
			}
		}
	}
	return $count;
}
?>

<div class="content">
<div id = "home">
	<div id="welcome">
		<br/>
		<table class="vtable" style="overflow:hidden">
			<tr>
				<td><h4>Campuses:</h4></td>				
				<td><p><?php echo rtrim($campus_string, ",") ; ?></p></td>
				<td><h4>Lease Warning Date:</h4></td>
				<td><p><?php echo $warning_date_value; ?></p></td>
			</tr>
			<tr>
				<td><h4>Complexes:</h4></td>
				<td><p><?php echo rtrim($group_string, ",") . '.'; ?><p/></td>
				<td><h4>Lease Deadline Date:</h4></td>
				<td><p><?php echo $deadline_date_value; ?></p></td>
			</tr>
			<tr>
				<td><h4>Number of Buildings:</h4></td>
				<td><p><?php echo $building_count; ?></p></td>
				
				<td><h4>Users Need Email:</h4></td>
				<td><p><?php echo $user_needs_email_count; ?></p></td>
					
			</tr>
			<tr>
				<td><h4>Number of Rooms:</h4></td>				
				<td><p><?php echo $total_room_count; ?></p></td>
				
				<td><h4>Users Completed Form:</h4></td>
				<td><p><?php echo $user_completion_count; ?></p></td>
			</tr>
			<tr>
				<td><h4>Gender counts:</h4></td>
				<td><p><?php echo 'Males:'. $males_count;
						  echo '<br/><br/>';
						  echo 'Females:'. $females_count; ?> 
				</p></td>
				<td><h4> Students Per Complex <h4></td>
				<td><p><?php
					$array_counter = 0;
					/**
					* Gets the name of the building based on the id of the building.
					*/
					foreach ($group_arr as $key => $value)
					{
						if(isset($key) && isset($group_arr) && isset($value))
						{
							echo $key;
						  	echo ': ';
							echo $value;
						  	echo '<br/><br/>';
						}
					}
				?></p></td>
			</tr>
		</table>
		<br/><br/>
	</div>
</div>
<?php
include ('../includes/footer.html');
?>
