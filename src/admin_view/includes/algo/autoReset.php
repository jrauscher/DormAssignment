<?php
include ('../../../includes/svrConnect.php');

$roomReset = "UPDATE `rooms` SET `group_id`=0,`num_students`=0,`gender`=0,`smoking`=0 WHERE 1"; /**< SQL that resets the rooms to 0, or so that there is no longer any students in the rooms. */

$groupReset = "DELETE FROM groups WHERE 1"; /**< SQL that resets the groups table. */
$studentReset = "UPDATE `students` SET `group_id`=0,`room_num`=0,`build_id`=0 WHERE 1"; /**< SQL that resets where the students have been placed. */
$roomLetReset = "UPDATE `room_letter` SET `student_id`=0 WHERE 1"; /**< SQL that resets the room_letter table so no students are in it. */

$roomRestQ = mysqli_query($dbconn, $roomReset) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the $roomReset SQL Query. */
$groupRestQ = mysqli_query($dbconn, $groupReset) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the $groupReset SQL Query. */
$studentRestQ = mysqli_query($dbconn, $studentReset) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the $studentReset SQL Query. */
$roomLetRestQ = mysqli_query($dbconn, $roomLetReset) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the $roomLetReset SQL Query. */

print<<<END
<script>
window.location="../../settings.php?validate=Unassigned all students from their rooms successfully!";
</script>
END;

?>
