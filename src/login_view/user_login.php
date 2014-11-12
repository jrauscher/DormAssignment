<?php # Script 12.1 - login_page.inc.php
// Include the header:
$page_title = 'Login';
// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	 echo '<h1>Error!</h1>
 	 <p class="error">The following error(s) occurred:<br />';
	 foreach ($errors as $msg) {
	 	 echo " - $msg<br />\n";
 	 }
 	 echo '</p><p>Please try again.</p>';
}

// Display the form:
?><h1>Login</h1>
<form action="../admin_view/validate/user_loginVal.php" method="post">
	 <p>Email Address: <input type="text" name="email" size="20" maxlength="60" /> </p>
	 <p>Password: <input type="password" name="pass" size="20" maxlength="20" /> </p>
	 <p><input type="submit" name="submit" value="Login" /></p>
</form>
