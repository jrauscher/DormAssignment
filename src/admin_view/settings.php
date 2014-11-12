<?php
	include ('../includes/svrConnect.php');

$was_errors = false;
$errors = array();

/* Set up your query in a string. */
$buildings = "SELECT build_id AS ID, building_name AS 'Building Name', building_letter AS Letter, campus AS Campus, num_rooms AS 'Number of Rooms', floor AS Floors, lease AS 'Lease Type', RA_rooms AS 'RA Rooms', handicapped_rooms AS 'Handicapped Rooms' FROM building WHERE complex=0 ORDER BY building_name";
$campus = "SELECT DISTINCT Campus FROM building";
$student = "SELECT student_ID AS ID, first_name AS 'First Name', last_name AS 'Last Name', email AS 'Email' FROM students";
$users = "SELECT student_id AS ID, username AS Username FROM users";
$admins = "SELECT admin_id AS ID, username AS Username FROM admins";
$notif = "SELECT form_name AS 'Form Name', deadline_date AS Deadline, warning_date AS 'Warning Date' FROM form_settings";
$complex_names = "SELECT DISTINCT building_name FROM building WHERE complex=1";
$complex_names2 = "SELECT DISTINCT building_name AS 'Complex Name' FROM building WHERE complex=1";
$formNames = "SELECT DISTINCT form_name FROM form_settings";
$error = "SELECT type AS Type FROM errors";

$resBuildings = mysqli_query($dbconn, $buildings);
$resFormNames = mysqli_query($dbconn, $formNames);
$resCamp = mysqli_query($dbconn, $campus);
$resCamp2 = mysqli_query($dbconn, $campus);
$resStudent = mysqli_query($dbconn, $student);
$resUsers = mysqli_query($dbconn, $users);
$resAdmins = mysqli_query($dbconn, $admins);
$resForms = mysqli_query($dbconn, $notif);
$complex = mysqli_query($dbconn, $complex_names);
$complex2 = mysqli_query($dbconn, $complex_names2);
$resErrors = mysqli_query($dbconn, $error);

$validate = 0;
$page = "Main";

if(isset($_GET['validate'])){
	$validate = mysqli_real_escape_string($dbconn, $_GET['validate']);
}
if(isset($_GET['page'])){
	$page = mysqli_real_escape_string($dbconn, $_GET['page']);
}
if(isset($_GET['error'])){
	$errors = mysqli_real_escape_string($dbconn, $_GET['error']);
}
if(isset($_GET['error'])){
	$errors = mysqli_real_escape_string($dbconn, $_GET['error']);
}

include ('../includes/header.html');
?>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="css/layout.css" type="text/css">
<div class = "content2">	
<div id = "home">
	<div id="welcome"> 	
	<br/>
		<div style="overflow:hidden">	
			<ul class="main_table">
				
				<li class="table_block">
					<h3><font color="white">Campuses</font></h3>
					<div class="footer">
						<a href="settings.php?page=aCampus" class="action_button">Add Campus</a>
						<br/><br/>
						<a href="settings.php?page=rCampus" class="action_button">Remove Campus</a>
						<br/><br/>
						<a href="settings.php?page=eCampus" class="action_button">Edit Campus</a>
					</div>
				</li>
				
				<li class="table_block">
					<h3><font color="white">Complex</font></h3>
					<div class="footer">
						<a href="settings.php?page=aComplex" class="action_button">Add Complex</a>
						<br/><br/>
						<a href="settings.php?page=rComplex" class="action_button">Remove Complex</a>
						<br/><br/>
						<a href="settings.php?page=eComplex" class="action_button">Edit Complex</a>
					</div>
				</li>
				
				<li class="table_block">
					<h3><font color="white">Buildings</font></h3>
					<div class="footer">
						<a href="settings.php?page=aBuilding" class="action_button">Add Building</a>
						<br/><br/>
						<a href="settings.php?page=rBuilding" class="action_button">Remove Building</a>
						<br/><br/>
						<a href="settings.php?page=eBuilding" class="action_button">Edit Building</a>
					</div>
				</li>
				
				<li class="table_block">
					<h3><font color="white">Rooms</font></h3>
					<div class="footer">
						<a href="settings.php?page=aRooms" class="action_button">Add Rooms</a>
						<br/><br/>
						<a href="settings.php?page=rRooms" class="action_button">Remove Rooms</a>
						<br/><br/>
						<a href="settings.php?page=eRooms" class="action_button">Edit Rooms</a>
					</div>
				</li>
			
				<li class="table_block">
					<h3><font color="white">Notifications</font></h3>
					<div class="footer">
						<a href="settings.php?page=nSettings" class="action_button">Settings</a>
						<br/><br/><br/>
						<br/><br/>
					</div>
				</li>
				<li class="table_block">
					<h3><font color="white">Students</font></h3>
					<div class="footer">
						<a href="settings.php?page=aStudent" class="action_button">Add Student</a>
						<br/><br/>
						<a href="settings.php?page=rStudent" class="action_button">Remove Student</a>
						<br/><br/><br/>
					</div>
				</li>
				<li class="table_block">
					<h3><font color="white">Accounts</font></h3>
					<div class="footer">
						<a href="settings.php?page=aAccounts" class="action_button">Add Account</a>
						<br/><br/>
						<a href="settings.php?page=rAccounts" class="action_button">Remove Account</a>
						<br/><br/><br/>
					</div>
				</li>
			</ul>
		</div>
	
	
		<div class="contBot">
		<?php
			if( isset($validate) && $validate != null && $validate != '' ){
				echo "<br/><br/><font size=5>$validate</font>";	
				if( isset($errors) && $errors != null && $errors != '' ){
					echo "<br/><br/><font size=5>ERRORS:</font>";	
					printResultTable($resErrors);
				}
			}
		?>
		<?php
			if($page == "aBuilding"){
				include ('includes/functions/addBuilding.html');
				printResultTable($resBuildings);
			}
			if($page == "rBuilding"){
				include ('includes/functions/rmBuilding.html');
				printResultTable($resBuildings);
			}
			if($page == "eBuilding"){
				include ('includes/functions/editBuilding.php');
			}
			if($page == "buildInput"){
				include ('includes/functions/editBuilding.php');
				include ('includes/upBuildTable.php');
			}
			if($page == "aCampus"){
				include ('includes/functions/addCampus.html');
				printResultTable($resCamp);
			}
			if($page == "rCampus"){
				include ('includes/functions/rmCampus.html');
				printResultTable($resCamp2);
			}
			if($page == "eCampus"){
				include ('includes/functions/editCampus.php');
			}
			if($page == "campusInput"){
				include ('includes/functions/editCampus.php');
				include ('includes/upCampusTable.php');
			}
			if($page == "nSettings"){
				include ('includes/functions/notSettings.html');
				printResultTable($resForms);
			}
			if($page == "aStudent"){
				include ('includes/functions/addStudent.html');
			}
			if($page == "rStudent"){
				include ('includes/functions/rmStudent.php');
				printResultTable($resStudent);
			}
			if($page == "aAccounts"){
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
			if($page == "rAccounts"){
				?>
					<br/>
				<?php
					include ('includes/functions/rmAdmin.html');
					printResultTable($resAdmins);
				?>
					<br/><br/><br/>
				<?php
					include ('includes/functions/rmUser.php');
					printResultTable($resUsers);
			}
			if($page == "aComplex"){
				include ('includes/functions/addComplex.html');
				printResultTable($complex2);
			}
			if($page == "rComplex"){
				include ('includes/functions/rmComplex.html');
				printResultTable($complex2);
			}
			if($page == "eComplex"){
				include ('includes/functions/editComplex.php');
			}
			if($page == "complexInput"){
				include ('includes/functions/editComplex.php');
				include ('includes/upComplexTable.php');
			}
			if($page == "aRooms"){
				include ('includes/functions/addRooms.html');
			}
			if($page == "rRooms"){
				include ('includes/functions/rmRooms.html');
			}
			if($page == "eRooms"){
				include ('includes/functions/editRooms.php');
			}
			if($page == "roomsInput"){
				include ('includes/functions/editRooms.php');
				include ('includes/upRoomsTable.php');
			}
			if($page == 14){
				include ('includes/functions/addRooms.html');
				include ('includes/functions/makeRoomTable.php');
			}
			if($page == 15){
				include ('includes/functions/rmRooms.html');
				include ('includes/functions/displayRooms.php');
			}
		?>	
			<script src="java-script/table.min.js" type="text/javascript"></script>
		</div>
	</div>
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

				echo '</table><br/>';
			} else { /* Number of rows is < 1 */
				echo '<p class="bg-info text-info text-center large">No results found.</p>';
			}
		} else { /* There was a syntax error in your SQL! */
			echo 'Query not successful.';
		}
}
?>

<?php
include ('../includes/footer.html');
?>

