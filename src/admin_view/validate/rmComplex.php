<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$complex = mysqli_real_escape_string($dbconn, $_POST['complex']); /**< Gets the complex ID from the settings.php?page=rComplex page. */
$valid = 1; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$getID = "SELECT build_id From building WHERE building_name='$complex' AND complex=1"; /**< SQL string that gets all the building id's that are complexes where the building_name = $complex. */
$IDS = mysqli_query($dbconn, $getID) or ($valid=2); /**< Runs the SQL Query in $getID. */

while( $row = mysqli_fetch_assoc($IDS) ){
	foreach($row as $val){
		$sql2="DELETE FROM room_letter WHERE build_id='$val'";
		$sql3="DELETE FROM rooms WHERE build_id='$val'";
		$result2 = mysqli_query($dbconn, $sql2) or ($valid=2);
		$result3 = mysqli_query($dbconn, $sql3) or ($valid=2);
	}
}	

$sql="DELETE FROM building WHERE building_name='$complex'"; /**< SQL string that deletes a building from the buildings table where building_name = $complex. */
$result = mysqli_query($dbconn, $sql) or ($valid=2); /**< Runs the SQL Query in $sql. */

if($valid = 1){
print<<<END
<script>
window.location="../settings.php?validate=Complex sucessfully removed!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Complex could not be removed!";
</script>
END;
}
?> 
