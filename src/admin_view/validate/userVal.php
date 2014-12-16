<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$NUID = mysqli_real_escape_string($dbconn, $_POST['NUID']);
$email = mysqli_real_escape_string($dbconn, $_POST['email']);
$complex = mysqli_real_escape_string($dbconn, $_POST['complex']);
$valid = 0;

$sql="INSERT INTO users (student_id, username, password, pwd_reset, needs_email, form_completion, building_name) VALUES ('$NUID','$email', 'FAKEPASSWORD','0', '0', '0', '$complex')";

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
