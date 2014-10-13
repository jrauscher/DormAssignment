<?php

/* Displays erros to browser */
ini_set('display_errors', true);

/* Connect to database: host, username, password, database name. */
/* If you're using multiple PHP files that need a database connection, you must reconnect on each of the pages. */
$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNODB');

if( !$dbconn ){
    die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
}

/* Set up your query in a string. */
$buildings = "SELECT building_name FROM building";
$NUIDs = "SELECT student_id FROM students WHERE student_id=10000000"; #Change student_id to * to print off everything on screen!!!!!
#$NUIDs = ""; #Change student_id to * to print off everything on screen!!!!!

/* Add a where clause if user has entered some data. */
if( isset($_POST['NUID_search']) && is_numeric($_POST['NUID_search']) && $_POST['NUID_search'] != null && $_POST['NUID_search'] != '' ){
    $NUIDs .= ' WHERE student_id  = ' . mysqli_real_escape_string($dbconn, $_POST['NUID_search']);
}

/* Send query to database. */
$result = mysqli_query($dbconn, $NUIDs);
include ('includes/header.html');
?>
<head>
	<title>Welcome to the View Page</title><!-- This title shows up in the broswer tab. -->
</head>
		 <script type="text/javascript" src="mktree.js"></script>
        	<link rel="stylesheet" href="mktree.css" type="text/css">

<div id="left_view">

<div id="left_view_title">
	Tree Thingy
</div>

<?php
$campus = "SELECT DISTINCT campus FROM building";
$building_names = "SELECT building_name FROM building";
$building_letters = "SELECT building_letter FROM building";
$room_number = "SELECT * FROM building, rooms WHERE building.build_id = "; 
$result_campus = mysqli_query($dbconn, $campus . ";");



echo '<ul class="mktree" id="tree">';
echo '<li class="liClosed"><font size="5">Campus</font>';
while ($campus_name = mysqli_fetch_assoc($result_campus)) //North or South
{
	echo '<ul>';
	foreach($campus_name as $campus_val)//For each North/South, do a Structure
	{
	echo '<li class="liClosed">' . $campus_val;
	$result_building_names = mysqli_query($dbconn, "SELECT DISTINCT building_name FROM building WHERE campus = '" . $campus_val . "';");
	while ($building_name = mysqli_fetch_assoc($result_building_names))//Structures
	{
		echo '<ul>';
		foreach($building_name as $building_val)//for each Structure, get Building Letters
		{
			echo '<li class="liClosed">' . $building_val;
			$result_building_id = mysqli_query($dbconn, "SELECT build_id FROM building WHERE building_name = '" . $building_val . "';"); // need to get building id not name
			while ($building_id = mysqli_fetch_assoc($result_building_id)) //get each building id
			{
				echo '<ul>';
				foreach($building_id as $building_id_val) //for each building letter
				{
					$building_letter = mysqli_query($dbconn, "SELECT building_letter FROM building WHERE build_id = '" . $building_id . "';"); //get building letters
					echo '<li class="liClosed">' . $building_val . " " . $building_id_val;
					$result_room_num = mysqli_query($dbconn, "SELECT room_num FROM rooms WHERE build_id = '" . $building_id . "';"); // get room numbers based on building_id
					while ($room_num = mysqli_fetch_assoc($result_room_num)) //get room numbers
					{
						echo '<ul>';
						foreach($room_num as $room_num_val) //for each room number
						{
							echo '<li class="liClosed">' . $room_num_val; //display the room number

							echo '</li>';
						}
						echo '</ul>';
					}
					echo '</li>';
				}
				echo '</ul>'; //building  ul
			}
			echo '</li>'; //building letter li
		}
		echo '</ul>'; //campus name ul
	}
	echo '</li>'; //campus name li
	}
	echo '</ul>'; //Campus ul
}
echo '</li>'; //Campus li
echo '</ul>'; //tree

?>
</div>
<div id="wrapper_right">
<div id="right_view_header">



		<!-- Form for user to enter information. -->
		<form action="" method="post">
			<label for="NUID_search">Search for contact(by name): </label>
			<input name="NUID_search" />

			<input type="submit" value="Submit" id= "pretty_small_button" />
		</form>
</div>

<div id="right_view_content">
		<?php
		/* SQL result will be false if a SQL syntax error exists. */
		if($result){
			echo 'Query successful.';
			/* Check to see if at least 1 row was returned. */
			/* CAREFUL: If using an update query, this will still return 0 even if a row was updated. */
			if( mysqli_num_rows($result) > 0){
				/* Start printing (echo) the table to the user. */
				echo '<table>';

				/* Use the first row to get the table headers. */
				$first_row = mysqli_fetch_assoc($result);
				echo '<tr>';				
				foreach($first_row as $col => $val){ /* Don't care about the $val here, but have to have it to get the $col */
					echo '<th>';
					echo $col;
					echo '</th>';
				}
				echo '</tr>';

				/* Make sure to reset the pointer back to beginning if you've used the result before. */
				mysqli_data_seek($result, 0);
				while( $row = mysqli_fetch_assoc($result) ){ /* mysqli_fetch_assoc will return each row until all rows have been read. Once it's done, it returns false. */
					echo '<tr>';
					foreach($row as $val){ /* Loop through array, each item in array gets assigned to $val */
						echo '<td>';
						echo $val;
						echo '</td>';
					}
					echo '</tr>';
				}

				echo '</table>';
			} else { /* Number of rows is < 1 */
				echo '<br /> No results found.';
			}
		} else { /* There was a syntax error in your SQL! */
			echo 'Query not successful.';
		}
		?>
</div>
</div>
<?php
include ('includes/footer.html');
?>

