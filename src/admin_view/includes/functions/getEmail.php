<?php

$myFile = fopen("/etc/ssmtp/ssmtp.conf", "r") or die("Unable to open file!"); /**< File discriptor opening the ssmtm config file for editing. */
$fileContent = fread($myFile,filesize("/etc/ssmtp/ssmtp.conf")); /**< Holds all the text that was stored in the file desciptor $myFile. */

$pattern = "/hostname=[^\s]+/"; /**< Regex that finds the text hostname followed by any number of charactors followed by a newline. */
preg_match($pattern,$fileContent,$matches);

$len = strlen($matches[0]); /**< Length of the first match our regex found ($pattern). */
$email = substr($matches[0],9,$len); /**< Pulls the email out of the match array which holds the values our regex found.  */

fclose($myFile);

?>

<br/><br/><font size=5>Change Email</font><br/><br/>
<form action="validate/changeEmail.php" method="post">
	<table>
		<tr>
			<th align="right">Current Email:</th>
			<?php echo "<th><p>$email</p></th>"; ?>	
		</tr>
		<tr>
			Note: Email must use gmail...
		</tr>
		<tr>
			<th align="right">New Email:</th>
			<th align="left"><input name="email" type="email" required></input></th>
		</tr>
		<tr>
			<th align="right">Email Password:</th>
			<th align="left"><input name="pass" type="password" required></input></th>
		</tr>
		<tr>
			<th align="left"> <input class="button1" type="submit" value="Submit" /></th>
		</tr>
	</table>
</form>
<br/>
