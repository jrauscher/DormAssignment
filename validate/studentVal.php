<?php
$con=mysqli_connect("localhost","root","root","UNODB");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// escape variables for security
$NUID = mysqli_real_escape_string($con, $_POST['NUID']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$complex = mysqli_real_escape_string($con, $_POST['complex']);
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
$result = mysqli_query($con, $sql) or die ('Error ' . mysqli_error($con));

print<<<END
<script>
window.location="../email.php";
</script>
END;
}
else{
print<<<END
<script>
window.location="../failed.php";
</script>
END;
}
?> 
