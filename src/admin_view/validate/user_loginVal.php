<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$email = mysqli_real_escape_string($dbconn, $_POST['email']);
$pass = mysqli_real_escape_string($dbconn, $_POST['pass']);
$valid = 0;

if( isset($email) && $email != null && $email != '' ){
        $valid ++;
}

if( isset($pass) && $pass != null && $pass != '' ){
        $valid ++;
}

if ($valid == 2){
	if($result_pass = mysqli_query($dbconn, "SELECT password FROM users WHERE usernname = '" . $email . "';"))
	{
		//if pass match post(pass) then go to submit form with:
		// email, nuid, building name
		{
			print<<<END
			<script>
			window.location="../email.php";
			</script>
			END;
		}
	}
}
else{
print<<<END
<script>
window.location="../failed.php";
</script>
END;
}
?> 
