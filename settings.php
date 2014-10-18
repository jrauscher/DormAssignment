<?php
function escape($conn, $string){
	return mysqli_real_escape_string($conn, $string);
}
function h($string){
	return htmlspecialchars($string);
}
/* Use this if you're on loki. Loki is set to not show errors, which makes it difficult to debug. */
ini_set('display_errors', true);

/* Connect to database: host, username, password, database name. */
/* If you're using multiple PHP files that need a database connection, you must reconnect on each of the pages. */
$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNODB');

if( !$dbconn ){
    die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
}

$was_errors = false;
$errors = array();

/* Set up your query in a string. */
$buildings = "SELECT build_id AS ID, building_name AS 'Building Name', building_letter AS Letter, campus AS Campus, num_rooms AS 'Number of Rooms', floor AS Floors, lease AS 'Lease Type', RA_rooms AS 'RA Rooms', handicapped_rooms AS 'Handicapped Rooms' FROM building";
$campus = "SELECT DISTINCT Campus FROM building";
$student = "SELECT student_ID AS ID, first_name AS 'First Name', last_name AS 'Last Name' FROM students";
$users = "SELECT student_id AS ID, username AS Username FROM users";
$admins = "SELECT admin_id AS ID, username AS Username FROM admins";
$notif = "SELECT * FROM form_settings";
$complex_names = "SELECT DISTINCT building_name FROM building";

$resBuildings = mysqli_query($dbconn, $buildings);
$resCamp = mysqli_query($dbconn, $campus);
$resCamp2 = mysqli_query($dbconn, $campus);
$resStudent = mysqli_query($dbconn, $student);
$resUsers = mysqli_query($dbconn, $users);
$resAdmins = mysqli_query($dbconn, $admins);
$resForms = mysqli_query($dbconn, $notif);
$complex = mysqli_query($dbconn, $complex_names);

$validate = 0;
$page = 0;

if(isset($_GET['validate'])){
	$validate = $_GET['validate'];
}
if(isset($_GET['page'])){
	$page = $_GET['page'];
}

include ('includes/header.html');
?>

<div id = "subform"> 
	<h2>Settings</h2>
	<br/>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="css/layout.css" type="text/css">
	<ul class="main_table">
		<li class="table_block">
			<h3><font color="white">Buildings</font></h3>
			<div class="footer">
				<a href="settings.php?page=1" class="action_button">Add Building</a>
			</div>
			<div class="footer">
				<a href="settings.php?page=2" class="action_button">Remove Building</a>
			</div>
		</li>
	
		<li class="table_block">
			<h3><font color="white">Campuses</font></h3>
			<div class="footer">
				<a href="settings.php?page=3" class="action_button">Add Campus</a>
			</div>
			<div class="footer">
				<a href="settings.php?page=4" class="action_button">Remove Campus</a>
			</div>
		</li>
		<li class="table_block">
			<h3><font color="white">Notifications</font></h3>
			<div class="footer">
				<a href="settings.php?page=5" class="action_button">Settings</a>
			<div class="footer">
				<br/>
			</div>
		</li>
		<li class="table_block">
			<h3><font color="white">Students</font></h3>
			<div class="footer">
				<a href="settings.php?page=6" class="action_button">Add Student</a>
			<div class="footer">
				<a href="settings.php?page=7" class="action_button">Remove Student</a>
			</div>
		</li>
		<li class="table_block">
			<h3><font color="white">Accounts</font></h3>
			<div class="footer">
				<a href="settings.php?page=8" class="action_button">Add Account</a>
			<div class="footer">
				<a href="settings.php?page=9" class="action_button">Remove Account</a>
			</div>
		</li>
<br/><br/><br/><br/><br/><br/><br/>
<?php
	if( isset($validate) && $validate != null && $validate != '' ){
		echo "$validate";	
	}
?>
<?php
	if($page == 1){
		include ('includes/functions/addBuilding.html');
		printResultTable($resBuildings);
	}
	if($page == 2){
		include ('includes/functions/rmBuilding.html');
		printResultTable($resBuildings);
	}
	if($page == 3){
		include ('includes/functions/addCampus.html');
		printResultTable($resCamp);
	}
	if($page == 4){
		include ('includes/functions/rmCampus.html');
		printResultTable($resCamp2);
	}
	if($page == 5){
		include ('includes/functions/notSettings.html');
		printResultTable($resForms);
	}
	if($page == 6){
		include ('includes/functions/addStudent.html');
	}
	if($page == 7){
		include ('includes/functions/rmStudent.html');
		printResultTable($resStudent);
	}
	if($page == 8){
		?>
			<br/>
		<?php
			include ('includes/functions/addAdmin.html');
			printResultTable($resAdmins);
		?>
			<br/><br/><br/>
		<?php
			include ('includes/functions/addUser.html');
			printResultTable($resUsers);
	
	}
	if($page == 9){
		?>
			<br/>
		<?php
			include ('includes/functions/rmAdmin.html');
			printResultTable($resAdmins);
		?>
			<br/><br/><br/>
		<?php
			include ('includes/functions/rmUser.html');
			printResultTable($resUsers);
	}
?>	
	<script src="java-script/table.min.js" type="text/javascript"></script>
</div>

<?php
function printResultTable($res){
		if($res){
			//echo 'Query successful.';
			/* Check to see if at least 1 row was returned. */
			/* CAREFUL: If using an update query, this will still return 0 even if a row was updated. */
			if( mysqli_num_rows($res) > 0){
				/* Start printing (echo) the table to the user. */
				echo '<table class="mytable">';


				/* Use the first row to get the table headers. */
				$first_row = mysqli_fetch_assoc($res);
				echo '<tr>';				
				foreach($first_row as $col => $val){ /* Don't care about the $val here, but have to have it to get the $col */
					echo '<th>';
					echo $col;
					echo '</th>';
				}
				echo '</tr>';

				/* Make sure to reset the pointer back to beginning if you've used the result before. */
				mysqli_data_seek($res, 0);
				while( $row = mysqli_fetch_assoc($res) ){ /* mysqli_fetch_assoc will return each row until all rows have been read. Once it's done, it returns false. */
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
				echo '<p class="bg-info text-info text-center large">No results found.</p>';
			}
		} else { /* There was a syntax error in your SQL! */
			echo 'Query not successful.';
		}
}
?>
<br/><br/><br/><br/>
</div>

<?php
include ('includes/footer.html');
?>

