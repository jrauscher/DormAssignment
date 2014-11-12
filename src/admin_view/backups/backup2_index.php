<?php
ini_set('display_errors', true);
$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNODB');
if( !$dbconn )
{
	die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error()); 
}
$buildings = "SELECT building_name FROM building";
$NUIDs = "SELECT student_id FROM students WHERE student_id=1000000";
if( 	isset($_POST['NUID_search']) && 
		is_numeric($_POST['NUID_search    ']) && 
		$_POST['NUID_search'] != null && 
		$_POST['NUID_search'] != '    ' 	)
{
	$NUIDs .= ' WHERE student_id  = ' . mysqli_real_escape_string(    $dbconn, $_POST['NUID_search']);
}

$result = mysqli_query($dbconn, $NUIDs);
$campus = "SELECT DISTINCT campus FROM building";
$building_names = "SELECT building_name FROM building";
$building_letters = "SELECT building_letter FROM building";
$room_number = "SELECT * FROM building, rooms WHERE building.build_id = ";
$result_campus = mysqli_query($dbconn, $campus . ";");

$campus_string ='';
$group_string = '';
$building_count = 0;
$total_room_count =0;
$avail_room_count =0;
$user_string = '';
$user_completion_count = 0;
$user_needs_email_count = 0;
$group_arr = array();
$array_counter=0;
include ('includes/header.html');

while($campus_name = mysqli_fetch_assoc($result_campus))
{
	foreach ($campus_name as $campus_val)
	{
		$campus_string = $campus_string . ' ' . $campus_val . ',';
		$result_building_names = mysqli_query($dbconn, "SELECT DISTINCT building_name FROM building WHERE campus = '" . $campus_val . "';");
		while ($building_name = mysqli_fetch_assoc($result_building_names))
		{
			foreach ($building_name as $building_val)
			{
				$group_arr[$building_val] = 0;
				$group_string = $group_string . ' '. $building_val . ',';
				//$campus_arr [$building_val] = 0;
				$array_counter = $array_counter + 1; 	
				$result_building_id = mysqli_query($dbconn, "SELECT build_id FROM building WHERE building_name = '" . $building_val . "';");
				while ($building_id = mysqli_fetch_assoc($result_building_id)) 
				{
					foreach($building_id as $building_id_val)
					{
						$building_letter = mysqli_query($dbconn, "SELECT building_letter FROM building WHERE build_id = '" . $building_id_val . "';");	
						$building_count = $building_count + 1;
						$result_room_num = mysqli_query($dbconn, "SELECT num_rooms FROM building WHERE build_id = '" . $building_id_val . "';"); 
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

$result_user_completion = mysqli_query($dbconn, "SELECT form_completion FROM users");
while ($user_completion = mysqli_fetch_assoc($result_user_completion))
{
	foreach($user_completion as $user_completion_val)
	{	if ($user_completion)
		{
			$user_completion_count = $user_completion_count + 1;
		}
	}
}

$result_user_needs_email = mysqli_query($dbconn, "SELECT needs_email FROM users");
while ($user_needs_email = mysqli_fetch_assoc($result_user_needs_email))
{
	foreach($user_needs_email as $user_needs_email_val)
	{	if ($user_needs_email_val)
		{
			$user_needs_email_count = $user_needs_email_count + 1;
		}
	}
}

$result_user_building_x = mysqli_query($dbconn, "SELECT building_name FROM users");
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
		
$males_count = 0;
$females_count = 0;
$student_gender_var ='';
$result_student_gender = mysqli_query($dbconn, "SELECT gender FROM students");
while ($student_gender = mysqli_fetch_assoc($result_student_gender))
{
	foreach($student_gender as $student_gender_val)
	{
			
			if($student_gender_val)
			{
				$females_count++;
			}
			else
			{
				$males_count++;
			}
	}
}

$result_warning_date = mysqli_query($dbconn, "SELECT warning_date FROM form_settings");
$warning_date = mysqli_fetch_assoc($result_warning_date);
$result_deadline_date = mysqli_query($dbconn, "SELECT deadline_date FROM form_settings");
$deadline_date = mysqli_fetch_assoc($result_deadline_date);
if($warning_date)
{
	foreach($warning_date as $warning_date_value){}
}
else
{
	$warning_date_value ='Not set up.';
}
if($deadline_date)
{
	foreach($deadline_date as $deadline_date_value){}
}
else
{
	$deadline_date_value ='Not set up.';
}

?>

<div id = "home">
	<div id="welcome">
		<h2>Welcome!  </h2>
		<p> <h3 style="margin-top:-20px">Data Overview:</h3></p>
	</div>
	<div id="home_left">
		<h4>Campuses:</h4>				
		<p>
			<?php
			echo rtrim($campus_string, ",") . '.';
			?>
			
		</p>
		<h4>Buildings Groups:</h4>				
		<p>
			<?php
			echo rtrim($group_string, ",") . '.';
			?>
		</p>
		<h4>Number of Buildings:</h4>				
		<p>
			<?php
				echo $building_count;
			?>
		</p>
		<h4>Number of Rooms:</h4>				
		<p>
			<?php
			//	echo $room_count;
				echo $total_room_count;
			?>
		</p>
		<h4>Gender counts:</h4>
			<?php
				echo '<table><tr><td align="left"> Males:</td><td align="right">' . $males_count  . '</td></tr>';
				echo '<tr><td align="left"> Females:</td><td align="right">' . $females_count  . '</td></tr></table>';
					
			?>
	</div>
	<div id="home_right">
		<h4>Warning Date:</h4>
		<p>
			<?php
				echo $warning_date_value ;
			?>
		</p>
		<h4>Deadline Date:</h4>
		<p>
			<?php
				echo $deadline_date_value;
			?>
		</p>
		<h4>Number of users completed form:</h4>
		<p>
			<?php
				echo $user_completion_count;
			?>
		</p>
		<h4>Number of users need email:</h4>
		<p>
			<?php
				echo $user_needs_email_count;
			?>
		</p>
		<table>
		<?php
		$array_counter = 0;
		/*echo '<tr><th align="left">Building Group:</th><th align="right">Student Count</th></tr><tr><td>&nbsp</td></tr>';*/
		echo '<h4> Students Per Building Group <h4>';
		foreach ($group_arr as $key => $value)
		{
			if(isset($key) && isset($group_arr) && isset($value))
			{
				echo '<tr><td align="left">' . $key . ':</td><td align="right">' . $value  . '</td></tr>';
			}
		}
		?>
		</table>

	</div>
</div>
<?php
include ('includes/footer.html');
?>