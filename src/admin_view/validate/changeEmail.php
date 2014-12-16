<?php
include ('../../includes/svrConnect.php');
$valid = 1;

$newEmail = mysqli_real_escape_string($dbconn, $_POST['email']);
$newPass = mysqli_real_escape_string($dbconn, $_POST['pass']);

$myFile = "/etc/ssmtp/ssmtp.conf";

$myFile = fopen("/etc/ssmtp/ssmtp.conf", "r") or die("Unable to open file!");
$fileContent = fread($myFile,filesize("/etc/ssmtp/ssmtp.conf"));
fclose($myFile);

$oldemail = "hostname=";
$newemail = "hostname=$newEmail";

$olduser = "AuthUser=";
$newuser = "AuthUser=$newEmail";

$oldpass = "AuthPass=";
$newpass = "AuthPass=$newPass";

$patterns = array();
$patterns[0] = '/hostname=[^\s]+/';
$patterns[1] = '/AuthUser=[^\s]+/';
$patterns[2] = '/AuthPass=[^\s]+/';
$replacements = array();
$replacements[2] = 'hostname='.$newEmail.'';
$replacements[1] = 'AuthUser='.$newEmail.'';
$replacements[0] = 'AuthPass='.$newPass.'';

$newFileContent = replace($patterns,$replacements,$fileContent);

if($newFileContent != ""){
	file_put_contents("/etc/ssmtp/ssmtp.conf",$newFileContent);
}else{
	$valid = 2;
}

function replace ($patterns, $replacements,$string){
	return preg_replace($patterns, $replacements, $string);
}

if($valid == 1){
print<<<END
<script>
window.location="../settings.php?validate=Email sucessfully updated!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../settings.php?validate=ERROR: Email could not be updated!";
</script>
END;
}
?> 

