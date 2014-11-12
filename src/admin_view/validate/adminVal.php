<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$adName = mysqli_real_escape_string($dbconn, $_POST['ADID']);
$psw = mysqli_real_escape_string($dbconn, $_POST['PSW']);
$valid = 0;

$sql="INSERT INTO admins (admin_id,username,password,pwd_reset)VALUES ('DEFAULT','$adName','$psw','0')";

if( isset($adName) && $adName != null && $adName != '' ){
        $valid ++;
}

if( isset($psw) && $psw != null && $psw != '' ){
        $valid ++;
}

if ($valid == 2){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

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
