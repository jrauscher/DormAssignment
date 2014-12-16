<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$PWD = mysqli_real_escape_string($dbconn, $_POST['PSW']);
$sID = mysqli_real_escape_string($dbconn, $_POST['student_id']);
$valid = 0;

$sql = "UPDATE `users` SET `password`='$PWD', `pwd_reset`='1' WHERE student_id='$sID'";

if( isset($PWD) && $PWD != null && $PWD != '' ){
	$valid ++;
}

if( isset($sID) && $sID != null && $sID != '' && is_numeric($sID) ){
        $valid ++;
}

if ($valid == 2){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

print<<<END
<script>
window.location="../settings.php?validate=Student password updated sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Student password not updated, invalid input!";
</script>
END;
}
?> 
