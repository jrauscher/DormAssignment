<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$NUID = mysqli_real_escape_string($dbconn, $_POST['NUID']); /**< Gets the Student ID from the page=aAccounts page. */
$email = mysqli_real_escape_string($dbconn, $_POST['email']); /**< Gets the email from the page=aAccounts page. */
$complex = mysqli_real_escape_string($dbconn, $_POST['complex']); /**< Gets the complex from the page=aAccounts page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql="INSERT INTO users (student_id, username, password, pwd_reset, needs_email, form_completion, building_name) VALUES ('$NUID','$email', 'FAKEPASSWORD','0', '0', '0', '$complex')"; /**< SQL string that adds a new user to the users table using the $NUID, $email, and $complex variables. */

if( isset($NUID) && $NUID != null && $NUID != '' && is_numeric($NUID) ){
        $valid ++;
}

if( isset($email) && $email != null && $email != '' ){
        $valid ++;
}

if( isset($complex) && $complex != null && $complex != '' ){
        $valid ++;
}

if ($valid == 3){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

print<<<END
<script>
window.location="../settings.php?validate=User added sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=Error: User was not added, invalid input!";
</script>
END;
}
?> 
