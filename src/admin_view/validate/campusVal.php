<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$complex = mysqli_real_escape_string($dbconn, $_POST['complex']); /**< Gets the complex ID from the settings.php?page=aCampus page. */
$campus = mysqli_real_escape_string($dbconn, $_POST['campus']); /**< Gets the campus ID from the settings.php?page=aCampus page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql="INSERT INTO building (build_id, building_name, building_letter, lease, campus, num_rooms, floor, RA_rooms, handicapped_rooms) VALUES ('DEFAULT', '$complex','',0,'$campus',0,0,0,1)"; /**< SQL string that addes a new campus into the buildings table. */


if( isset($complex) && $complex != null && $complex != '' ){
        $valid ++;
}

if( isset($campus) && $campus != null && $campus != '' ){
        $valid ++;
}

if ($valid == 2){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the SQL in $sql. */

print<<<END
<script>
window.location="../settings.php?validate=Campus added sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Campus not added, invalid input!";
</script>
END;
}
?> 
