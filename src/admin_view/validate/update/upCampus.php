<?php
	include ('../../../includes/svrConnect.php');

// escape variables for security
$newC = mysqli_real_escape_string($dbconn, $_POST['newCamp']);
$oldC = mysqli_real_escape_string($dbconn, $_POST['oldCamp']);
$valid = 0;
$sql = "UPDATE `building` SET `campus`='$newC' WHERE campus ='$oldC'";

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
