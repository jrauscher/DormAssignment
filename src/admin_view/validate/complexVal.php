<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$cName = mysqli_real_escape_string($dbconn, $_POST['cName']); /**< Gets the complex name from the settings.php?page=aComplexi page. */
$campus = mysqli_real_escape_string($dbconn, $_POST['campus']); /**< Gets the campus name from the settings.php?page=aComplexi page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql="INSERT INTO building (build_id, building_name, building_letter, lease, campus, num_rooms, floor, RA_rooms, handicapped_rooms, complex) VALUES ('DEFAUL','$cName','',0,'$campus',0,0,0,0,1)"; /**< SQL string that adds a new building to the building table with the complex bit set to 1 and with the new information provided in $cName and $campus. */

if( isset($cName) && $cName != null && $cName != '' ){
        $valid ++;
}
if( isset($campus) && $campus != null && $campus != '' ){
        $valid ++;
}

if ($valid == 2){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

print<<<END
<script>
window.location="../settings.php?validate=Complex added sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Complex not added, invalid input!";
</script>
END;
}
?> 
