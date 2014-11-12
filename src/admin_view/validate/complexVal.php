<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$cName = mysqli_real_escape_string($dbconn, $_POST['cName']);
$campus = mysqli_real_escape_string($dbconn, $_POST['campus']);
$valid = 0;

$sql="INSERT INTO building (build_id, building_name, building_letter, lease, campus, num_rooms, floor, RA_rooms, handicapped_rooms, complex) VALUES ('DEFAUL','$cName','',0,'$campus',0,0,0,0,1)";

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
