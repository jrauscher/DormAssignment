<?php
	include ('../../../includes/svrConnect.php');

// escape variables for security
$newC = mysqli_real_escape_string($dbconn, $_POST['newCamp']); /**< Gets the new campus name from the page=eCampus page. */
$oldC = mysqli_real_escape_string($dbconn, $_POST['oldCamp']); /**< Gets the old campus name from the page=eCampus page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql = "UPDATE `building` SET `campus`='$newC' WHERE campus ='$oldC'"; /**< SQL Query that updates the old campus with teh new Campus name stores in $newC. */

if( isset($newC) && $newC != null && $newC != '' ){
        $valid ++;
}

if ($valid == 1){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

print<<<END
<script>
window.location="../../settings.php?validate=Campus updated sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../../settings.php?validate=ERROR: Campus not updated, invalid input!";
</script>
END;
}
?> 
