<?php
include ('../../includes/svrConnect.php');
$valid = 1; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$newEmail = mysqli_real_escape_string($dbconn, $_POST['email']); /**< Gets the new email from the settings.php?page=cEmail page. */
$newPass = mysqli_real_escape_string($dbconn, $_POST['pass']);  /**< Gets the password for the new email from the settings.php?page=cEmail page. */

$myFile = fopen("/etc/ssmtp/ssmtp.conf", "r") or die("Unable to open file!"); /**< File discriptor that opens the ssmtp.conf file */
$fileContent = fread($myFile,filesize("/etc/ssmtp/ssmtp.conf")); /**< Gets the text out the file that was opened in the file discriptor $myFile. */
fclose($myFile);

$oldemail = "hostname="; /**< Used to find the old email in the ssmtp.conf file. */
$newemail = "hostname=$newEmail";  /**< Replaces the $oldemail with this variable in ssmtp.conf file. */

$olduser = "AuthUser="; /**< Used to find the old username in the ssmtp.conf file. */
$newuser = "AuthUser=$newEmail";  /**< Replaces the $olduser with this variable in ssmtp.conf file. */

$oldpass = "AuthPass="; /**< Used to find the old password in the ssmtp.conf file. */
$newpass = "AuthPass=$newPass";  /**< Replaces the $oldpass with this variable in ssmtp.conf file. */

$patterns = array(); /**< Array of all patterns we want to find in the ssmtp.conf file. */
$patterns[0] = '/hostname=[^\s]+/'; /**< Regex to find the hostname in the ssmtp.conf file */
$patterns[1] = '/AuthUser=[^\s]+/'; /**< Regex to find the username in the ssmtp.conf file */
$patterns[2] = '/AuthPass=[^\s]+/'; /**< Regex to find the password in the ssmtp.conf file */

$replacements = array(); /**< Array of what we are replacing the pattern matches with. */
$replacements[2] = 'hostname='.$newEmail.''; /**< Stores the new Hostname. */
$replacements[1] = 'AuthUser='.$newEmail.''; /**< Stores the new Username. */
$replacements[0] = 'AuthPass='.$newPass.''; /**< Stores the new Password. */

$newFileContent = replace($patterns,$replacements,$fileContent); /**< Replaces the matching patterns in the patterns array with the text in the replacements array */

if($newFileContent != ""){
	file_put_contents("/etc/ssmtp/ssmtp.conf",$newFileContent);
}else{
	$valid = 2;
}


/**
* <pre>
* REPLACE: 
* TAKES: Array of regex patterns, Array of replacement strings
* RETURNS: a String with the with all the matching patterns replaced by the replacement array strings. 
*</pre>
*/
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

