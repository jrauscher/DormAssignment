<?php
	include ('../includes/svrConnect.php');

// escape variables for security
$username = mysqli_real_escape_string($dbconn, $_POST['username']);
$pass = mysqli_real_escape_string($dbconn, $_POST['password']);
$valid = 0;

if( isset($username) && $username != null && $username != '' ){
        $valid ++;
}

if( isset($pass) && $pass != null && $pass != '' ){
        $valid ++;
}

$dbPass = "";
$VAL = "";

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
