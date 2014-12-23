<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$bName = mysqli_real_escape_string($dbconn, $_POST['bName']); /**< gets the building name from the settings.php?page=rBuilding page. */
$let = mysqli_real_escape_string($dbconn, $_POST['letter']);  /**< gets the building letter from the settings.php?page=rBuilding page. */
$valid = 1; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$getID="SELECT build_id FROM building WHERE building_name='$bName' AND building_letter='$let'"; /**< gets the building id from the building table where the bulding_name = $bName, and where building letter = $let. */
$BID = mysqli_query($dbconn, $getID) or ($valid=2); /**< Runs the SQL Query in $getID. */
$ID = mysqli_fetch_assoc($BID); /**< Gets the first BID from the SQL result. */

$sql="DELETE FROM building WHERE building_name='$bName' AND building_letter='$let'"; /**< SQL string that deletes the building from the building table where the building_name = $bName and where the building_letter = $let. */
$sql2="DELETE FROM room_letter WHERE build_id='$ID'"; /**< SQL string that deletes all the room_letters from the room_letter table where build_id = $ID. */
$sql3="DELETE FROM rooms WHERE build_id='$ID'"; /**< SQL string that deletes all rooms from the rooms table where build_id = $ID. */

$result = mysqli_query($dbconn, $sql) or ($valid=2); /**< Runs the SQL Query in $sql. */
$result2 = mysqli_query($dbconn, $sql2) or ($valid=1); /**< Runs the SQL Query in $sql2. */
$result3 = mysqli_query($dbconn, $sql3) or ($valid=1); /**< Runs the SQL Query in $sql3. */

if($valid == 1){
print<<<END
<script>
window.location="../settings.php?validate=Building sucessfully removed!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Building could not be removed!";
</script>
END;
}
?> 
