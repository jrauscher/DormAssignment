<?php
	include ('../../../includes/svrConnect.php');

// escape variables for security
$newC = mysqli_real_escape_string($dbconn, $_POST['newComp']);
$newCamp = mysqli_real_escape_string($dbconn, $_POST['newCamp']);
$oldC = mysqli_real_escape_string($dbconn, $_POST['oldComp']);
$valid = 0;
$sql = "UPDATE `building` SET `building_name`='$newC',`campus`='$newCamp' WHERE building_name ='$oldC'";

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
