<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$campus = mysqli_real_escape_string($dbconn, $_POST['campus']); /**< Gets the campus from the settings.php?page=rCampus page. */ 
$valid = 1; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$getID = "SELECT build_id From building WHERE campus='$campus'"; /**< SQL string that gets all the building id's from the buildings table where campus = $campus. */
$IDS = mysqli_query($dbconn, $getID) or ($valid=2); /**< Runs the SQL Query in $getID. */

while( $row = mysqli_fetch_assoc($IDS) ){
	foreach($row as $val){
		$sql2="DELETE FROM room_letter WHERE build_id='$val'";
		$sql3="DELETE FROM rooms WHERE build_id='$val'";
		$result2 = mysqli_query($dbconn, $sql2) or ($valid=2);
		$result3 = mysqli_query($dbconn, $sql3) or ($valid=2);
	}
}	

$sql="DELETE FROM building WHERE campus='$campus'"; /**< SQL string that deletes all the buildings from the buildings table where campus = $campus. */
$result = mysqli_query($dbconn, $sql) or ($valid=2); /**< Runs the SQL Query in $sql. */

if($valid = 1){
print<<<END
<script>
window.location="../settings.php?validate=Campus sucessfully removed!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Campus could not be removed!";
</script>
END;
}
?> 
