<?php
$con=mysqli_connect("localhost","root","root","UNODB");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// escape variables for security
$bName = mysqli_real_escape_string($con, $_POST['bName']);
$letter = mysqli_real_escape_string($con, $_POST['letter']);
$campus = mysqli_real_escape_string($con, $_POST['campus']);
$roomNum = mysqli_real_escape_string($con, $_POST['rnum']);
$floorNum = mysqli_real_escape_string($con, $_POST['fnum']);
$lease = mysqli_real_escape_string($con, $_POST['lease']);
$roomRA = mysqli_real_escape_string($con, $_POST['raNum']);
$roomHC = mysqli_real_escape_string($con, $_POST['hcNum']);
$valid = 1;

$sql="INSERT INTO building (build_id, building_name, building_letter, lease, campus, num_rooms, floor, RA_rooms, handicapped_rooms) VALUES ('DEFAULT', '$bName','$letter', '$lease','$campus', '$roomNum', '$floorNum', '$roomRA', '$roomHC')";


if( isset($bName) && $bName != null && $bName != '' ){
        $valid ++;
}

if( isset($roomNum) && $roomNum != null && $roomNum != '' && is_numeric($roomNum) ){
        $valid ++;
}

if( isset($campus) && $campus != null && $campus != '' ){
        $valid ++;
}

if( isset($floorNum) && $floorNum != null && $floorNum != '' && is_numeric($floorNum) ){
        $valid ++;
}
if( isset($lease) && $lease != null && $lease != '' && is_numeric($lease) ){
        $valid ++;
}
if( isset($roomRA) && $roomRA != null && $roomRA != '' && is_numeric($roomRA) ){
        $valid ++;
}
if( isset($roomHC) && $roomHC != null && $roomHC != '' && is_numeric($roomHC) ){
        $valid ++;
}

if ($valid == 8){
$result = mysqli_query($con, $sql) or die ('Error ' . mysqli_error($con));

print<<<END
<script>
window.location="../settings.php?validate='Campus added sucessfully!'";
</script>
END;
}
else{
print<<<END
<script>
window.location="../failed.php";
</script>
END;
}
?> 
