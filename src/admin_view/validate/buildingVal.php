<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$bName = mysqli_real_escape_string($dbconn, $_POST['complex']);
$letter = mysqli_real_escape_string($dbconn, $_POST['letter']);
$campus = mysqli_real_escape_string($dbconn, $_POST['campus']);
$lease = mysqli_real_escape_string($dbconn, $_POST['lease']);
$valid = 0;

$sql="INSERT INTO building (build_id, building_name, building_letter, lease, campus, num_rooms, floor, RA_rooms, handicapped_rooms, complex) VALUES ('DEFAULT', '$bName','$letter', '$lease','$campus',0,0,0,0,0)";


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
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

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
