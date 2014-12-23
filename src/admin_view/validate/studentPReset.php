<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$PWD = mysqli_real_escape_string($dbconn, $_POST['PSW']); /**< Gets the new password from the settings.php?page=aAccounts page. */
$sID = mysqli_real_escape_string($dbconn, $_POST['student_id']); /**< Gets the new student_id from the settings.php?page=aAccounts page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql = "UPDATE `users` SET `password`='$PWD', `pwd_reset`='1' WHERE student_id='$sID'"; /**< SQL string that updates the user from the $sID with the new password that was provided from $PWD. */

if( isset($PWD) && $PWD != null && $PWD != '' ){
	$valid ++;
}

if( isset($sID) && $sID != null && $sID != '' && is_numeric($sID) ){
        $valid ++;
}

if ($valid == 2){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the SQL Query $sql. */

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
