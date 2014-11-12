<?php
$campus = mysqli_real_escape_string($dbconn, $_POST['campus']);

echo "<p>Selected Campus: $campus</p>";
echo '<form action="validate/update/upCampus.php" method="post">';
	echo "&nbsp; &nbsp; &nbsp; New campus name:";
	echo '<input name="newCamp" type="text" value="';
	echo $campus;
	echo '"/></input><br/><br/>';
	echo '<input name="oldCamp" type="hidden" value="';
	echo $campus;
	echo '"/></input>';
echo '<input class="button1" type="submit" value="Update"/><br/>';
echo '<br/><br/>';
