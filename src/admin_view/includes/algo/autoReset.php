<?php
include ('../../../includes/svrConnect.php');


$roomReset = "UPDATE `rooms` SET `group_id`=0,`num_students`=0,`gender`=0,`smoking`=0 WHERE 1";

$groupReset = "DELETE FROM groups WHERE 1";
$studentReset = "UPDATE `students` SET `group_id`=0,`room_num`=0,`build_id`=0 WHERE 1";
$roomLetReset = "UPDATE `room_letter` SET `student_id`=0 WHERE 1";

$roomRestQ = mysqli_query($dbconn, $roomReset) or die ('Error ' . mysqli_error($dbconn));
$groupRestQ = mysqli_query($dbconn, $groupReset) or die ('Error ' . mysqli_error($dbconn));
$studentRestQ = mysqli_query($dbconn, $studentReset) or die ('Error ' . mysqli_error($dbconn));
$roomLetRestQ = mysqli_query($dbconn, $roomLetReset) or die ('Error ' . mysqli_error($dbconn));

print<<<END
<script>
window.location="../../settings.php?validate=Unassigned all students from their rooms successfully!";
</script>
END;

?>
