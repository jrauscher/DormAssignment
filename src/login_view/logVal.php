<?php
	include ('../includes/svrConnect.php');

// escape variables for security
$username = mysqli_real_escape_string($dbconn, $_POST['username']); /**< The submitted username. */
$pass = mysqli_real_escape_string($dbconn, $_POST['password']); /**< The submitted password. */
$valid = 0; /**< Valid must equal the total number of input variables at the end of the program to insure input variables contain valid text. */


/**
* Increments $valid if the $username is filled out.
*/
if( isset($username) && $username != null && $username != '' ){
        $valid ++;
}
/**
*
* Increments $valid if the $pass is filled out.
*/
if( isset($pass) && $pass != null && $pass != '' ){
        $valid ++;
}

$dbPass = ""; /**< The passwords that will allow access to the system. */
$VAL = ""; /**< Whether or not the user has access. */

if ($valid == 2){
	$sl = "SELECT password FROM users WHERE username = '$username'";
	$sl_res = mysqli_query($dbconn, $sl) or die ('Error ' . mysqli_error($dbconn));

	
	while ($row = mysqli_fetch_array($sl_res)){
			$dbPass = $row['password'];
	}
	
	if($dbPass == $pass){
		$VAL = 1;
	}else{
	
		$al = "SELECT password FROM admins WHERE username = '$username'";
		$al_res = mysqli_query($dbconn, $al) or die ('Error ' . mysqli_error($dbconn));
	
		while ($row = mysqli_fetch_array($al_res)){
			$dbPass = $row['password'];
		}

		if($dbPass == $pass){
			$VAL = 2;
		}
	}
}else{
	$VAL = 0;
}

if($VAL == 2){
print<<<END
<script>
window.location="../admin_view/index.php";
</script>
END;
}
if($VAL == 1){
print<<<END
<script>
window.location="../user_view/index.php";
</script>
END;
}
else{
print<<<END
<script>
window.location="badLogin.html";
</script>
END;
}
?> 
