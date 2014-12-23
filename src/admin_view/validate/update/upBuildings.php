<?php
	include ('../../../includes/svrConnect.php');

// escape variables for security
$bName = mysqli_real_escape_string($dbconn, $_POST['bName']); /**< Gets the building name from the settings.php?page=eBuilding page. */
$let = mysqli_real_escape_string($dbconn, $_POST['letter']); /**< Gets the building letter from the settings.php?page=eBuilding page. */
$campus = mysqli_real_escape_string($dbconn, $_POST['campus']); /**< Gets the campus from the settings.php?page=eBuilding page. */
$lease = mysqli_real_escape_string($dbconn, $_POST['lease']); /**< Gets the building lease type from the settings.php?page=eBuilding page. */
$BID = mysqli_real_escape_string($dbconn, $_POST['oldComplex']); /**< Gets the old complex id from the settings.php?page=eBuilding page. */
$valid = 0; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */

$sql = "UPDATE `building` SET `building_name`='$bName',`campus`='$campus',`lease`='$lease',`building_letter`='$let' WHERE build_id ='$BID' AND complex=0"; /**< SQL string that updates buildings with the new infromation stored in $bName, $campus, $lease and $let where build_id = $BID. */

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
