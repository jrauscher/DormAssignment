<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$PWD = mysqli_real_escape_string($dbconn, $_POST['PSW']);
$aID = mysqli_real_escape_string($dbconn, $_POST['admin_id']);
$valid = 0;

$sql = "UPDATE `admins` SET `password`='$PWD' WHERE admin_id='$aID'";

if( isset($PWD) && $PWD != null && $PWD != '' ){
	$valid ++;
}

if( isset($aID) && $aID != null && $aID != '' && is_numeric($aID) ){
        $valid ++;
}

if ($valid == 2){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

print<<<END
<script>
window.location="../settings.php?validate=Admin password updated sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Admin password not updated, invalid input!";
</script>
END;
}
?> 
