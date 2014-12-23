<?php
	include ('../../../includes/svrConnect.php');

// escape variables for security
$newC = mysqli_real_escape_string($dbconn, $_POST['newComp']); /**< Gets new complex name from settings.php?page=eComplex page. */
$newCamp = mysqli_real_escape_string($dbconn, $_POST['newCamp']); /**< Gets new campus name from settings.php?page=eComplex page. */
$oldC = mysqli_real_escape_string($dbconn, $_POST['oldComp']); /**< Gets old complex name from settings.php?page=eComplex page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql = "UPDATE `building` SET `building_name`='$newC',`campus`='$newCamp' WHERE building_name ='$oldC'"; /**< SQL string that updates the a building in the building table with the new information stores in the $newC and $newCamp variables. */

if( isset($newC) && $newC != null && $newC != '' ){
        $valid ++;
}

if ($valid == 1){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

print<<<END
<script>
window.location="../../settings.php?validate=Complex updated sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../../settings.php?validate=ERROR: Complex not updated, invalid input!";
</script>
END;
}
?> 
