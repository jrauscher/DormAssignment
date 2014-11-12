<?php
function escape($conn, $string){
	return mysqli_real_escape_string($conn, $string);
}
function h($string){
	return htmlspecialchars($string);
}
/* Use this if you're on loki. Loki is set to not show errors, which makes it difficult to debug. */
ini_set('display_errors', true);

/* Connect to database: host, username, password, database name. */
/* If you're using multiple PHP files that need a database connection, you must reconnect on each of the pages. */
$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNODB');

if( !$dbconn ){
    die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
}

$was_errors = false;
$errors = array();

/* Set up your query in a string. */
$sLeaseMaleStd= "SELECT * FROM students WHERE gender=1 AND lease=9";
$lLeaseMaleStd = "SELECT * FROM students WHERE gender=1 AND lease=12";
$sLeaseFemaleStd= "SELECT * FROM students WHERE gender=0 AND lease=9";
$lLeaseFemaleStd = "SELECT * FROM students WHERE gender=0 AND lease=12";

$sLeaseMaleStdRes = mysqli_query($dbconn, $sLeaseMaleStd);
$lLeaseMaleStdRes = mysqli_query($dbconn, $lLeaseMaleStd);
$sLeaseFemaleStdRes = mysqli_query($dbconn, $sLeaseFemaleStd);
$lLeaseFemaleStdRes = mysqli_query($dbconn, $lLeaseFemaleStd);

// START ALGORITHM 




// END ALGORITHM



// PRINTS OUT RESULT
print<<<END
<script>
window.location="displayResult.php";
</script>
END;

?>
