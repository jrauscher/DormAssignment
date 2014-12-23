<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$PWD = mysqli_real_escape_string($dbconn, $_POST['PSW']); /**< Gets the new password from settings.php?page=mAccounts page. */
$aID = mysqli_real_escape_string($dbconn, $_POST['admin_id']); /**< Gets the admin id from settings.php?page=mAccounts page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql = "UPDATE `admins` SET `password`='$PWD' WHERE admin_id='$aID'"; /**<SQL string that updates the admin table with the user input information ($PWD, $aID) */

if( isset($PWD) && $PWD != null && $PWD != '' ){
	$valid ++;
}

if( isset($aID) && $aID != null && $aID != '' && is_numeric($aID) ){
        $valid ++;
}

if ($valid == 2){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the SQL Query in $sql. */

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
