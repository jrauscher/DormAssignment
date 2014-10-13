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
$campus_string ="";
$group_string = "";
$building_count = 0;
$room_count = 0;
$avail_room_count =0;
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
				$result_building_id = mysqli_query($dbconn, "SELECT build_id FROM building WHERE building_name = '" . $building_val . "';");
				while ($building_id = mysqli_fetch_assoc($result_building_id)) 
				{
					foreach($building_id as $building_id_val)
					{
						$building_letter = mysqli_query($dbconn, "SELECT building_letter FROM building WHERE build_id = '" . $building_id . "';");	
						$building_count = $building_count + 1;
						$result_room_num = mysqli_query($dbconn, "SELECT room_nuum FROM rooms WHERE build_id = '" . $building_id . "';"); 
						while ($room_num = mysqli_fetch_assoc($result_room_num)) 
						{
							foreach($room_num as $room_num_val) 
							{
								$room_count = $room_count + 1;
								
							}
						}
					}
				}
			}
		}
	}
}
				?>

<div id = "home">
	<div id="welcome">
		<h2>Welcome! (Under Construction) </h2>
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
			<h4>Number of Rooms</h4>				
			<p>
				<?php
					echo $room_count;
				?>
			</p>
		</div>
		<div id="w_top_right">
		</div>
		<div id="w_bottom_left">
		</div>
		<div id="w_bottom_right">
		</div>
	</div>
</div>
<?php
include ('includes/footer.html');
?>
