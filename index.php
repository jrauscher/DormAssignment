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
$campus_arr;
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
				$group_string = $group_string . ' '. $building_val . ',';
				$campus_arr [$building_val] = 0;
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
/*
$result_student_building = mysqli_query($dbconn, "SELECT build_id FROM users");
while ($user_building = mysqli_fetch_assoc($result_student_building))
{
	foreach($user_building as $user_building_value)
	{
			$campus_arr[$user_building_val] = $campus_arr[$user_building_value] + 1;
	}
}
*/		
?>

<div id = "home">
	<div id="welcome">
		<h2>Welcome!  </h2>
		<p> Here's an overview of current data:</p>
		<div id="w_top_left">
			<h4>Campuses:</h4>				
			<p>
				<?php
				echo $campus_string;
				?>
				
			</p>
			<h4>Buildings Groups:</h4>				
			<p>
				<?php
					echo $group_string;
				?>
			</p>
			<h4>Number of Buildings:</h4>				
			<p>
				<?php
					echo $building_count;
				?>
			</p>
		</div>
		<div id="w_top_right">
			<h4>Number of Rooms:</h4>				
			<p>
				<?php
				//	echo $room_count;
					echo $total_room_count;
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

</div>
		<div id="w_bottom_left">
			<h4>Gender counts:</h4>
			<p>
				<?php
					echo 'No female/male data available (hint!)';
				?>
			</p>
			<h4>Warning Date:</h4>
			<p>
				<?php
					echo '' ;
				?>
			</p>
			<h4>Deadline Date:</h4>
			<p>
				<?php
					echo '';
				?>
			</p>
		</div>
		<div id="w_bottom_right">		
			<ul>
			<?php
			$array_counter = 0;
			foreach ($campus_arr as $key => $value)
			{
				echo '<li>' . $key . ': ' . $value  . '</li>';
			}
			?>
			</ul>
		</div>
		
</div>
</div>
<?php
include ('includes/footer.html');
?>
