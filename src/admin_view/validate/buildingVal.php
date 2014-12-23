<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$bName = mysqli_real_escape_string($dbconn, $_POST['complex']); /**< Gets the new building name from the settings.php?page=aBuilding page. */
$letter = mysqli_real_escape_string($dbconn, $_POST['letter']); /**< Gets the new building letter from the settings.php?page=aBuilding page. */
$campus = mysqli_real_escape_string($dbconn, $_POST['campus']); /**< Gets campus for the new building from the settings.php?page=aBuilding page. */
$lease = mysqli_real_escape_string($dbconn, $_POST['lease']); /**< Gets the lease type for the new building from the settings.php?page=aBuilding page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql="INSERT INTO building (build_id, building_name, building_letter, lease, campus, num_rooms, floor, RA_rooms, handicapped_rooms, complex) VALUES ('DEFAULT', '$bName','$letter', '$lease','$campus',0,0,0,0,0)"; /**< SQL string that adds a new building to the databse using the variables $bName, $letter, $campus, $lease. */

if( isset($bName) && $bName != null && $bName != '' ){
        $valid ++;
}
if( isset($letter) && $letter != null && $letter != '' ){
        $valid ++;
}
if( isset($campus) && $campus != null && $campus != '' ){
        $valid ++;
}
if( isset($lease) && $lease != null && $lease != '' && is_numeric($lease) ){
        $valid ++;
}

if ($valid == 4){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the SQL Query in $sql. */

print<<<END
<script>
window.location="../settings.php?validate=Building added sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Building not added, invalid input!";
</script>
END;
}
?> 
