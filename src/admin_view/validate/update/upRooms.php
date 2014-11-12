<?php
	include ('../../../includes/svrConnect.php');

// escape variables for security
$bName = mysqli_real_escape_string($dbconn, $_POST['bName']);
$let = mysqli_real_escape_string($dbconn, $_POST['letter']);
$campus = mysqli_real_escape_string($dbconn, $_POST['campus']);
$lease = mysqli_real_escape_string($dbconn, $_POST['lease']);
$BID = mysqli_real_escape_string($dbconn, $_POST['oldComplex']);
$valid = 0;

$sql = "UPDATE `building` SET `building_name`='$bName',`campus`='$campus',`lease`='$lease',`building_letter`='$let' WHERE build_id ='$BID' AND complex=0";

if( isset($let) && $let != null && $let != '' ){
        $valid ++;
}
if( isset($lease) && $lease != null && $lease != '' && is_numeric($lease) ){
        $valid ++;
}

if ($valid == 2){
$result = mysqli_query($dbconn, $sql) or die ('Error ' . mysqli_error($dbconn));

print<<<END
<script>
window.location="../../settings.php?validate=Building updated sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
window.location="../../settings.php?validate=ERROR: Building not updated, invalid input!";
</script>
END;
}
?> 
