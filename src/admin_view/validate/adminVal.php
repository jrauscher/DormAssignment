<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$adName = mysqli_real_escape_string($dbconn, $_POST['ADID']); /**< Gets the admin name from the settings.php?page=aAccounts page. */
$psw = mysqli_real_escape_string($dbconn, $_POST['PSW']); /**< Gets the admin password from the settings.php?page=aAccounts page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql="INSERT INTO admins (admin_id,username,password,pwd_reset)VALUES ('DEFAULT','$adName','$psw','0')"; /**< SQL string that creates a new admin using the variables $adName and $psw. */

if( isset($adName) && $adName != null && $adName != '' ){
        $valid ++;
}

if( isset($psw) && $psw != null && $psw != '' ){
        $valid ++;
}

if ($valid == 2){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the SQL Query in $sql. */

print<<<END
<script>
window.location="../settings.php?validate=New admin added sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Admin could not be added!";
</script>
END;
}
?> 
