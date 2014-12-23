<?php
    include ('../includes/svrConnect.php');

$dropStudentsTable = "DROP TABLE students"; /**< SQl query to drop the student table. */
mysqli_query($dbconn, $dropStudentsTable);
$makeStudentsTable = "CREATE TABLE students SELECT * FROM students_temp"; /**< SQl query to copy the temporary students table to the students table. */
mysqli_query($dbconn, $makeStudentsTable);

$dropGroupTable = "DROP TABLE groups"; /**< SQl query to drop the groups table. */
mysqli_query($dbconn, $dropGroupTable);
$makeGroupTable = "CREATE TABLE groups SELECT * FROM groups_temp"; /**< SQl query to copy the temporary groups table to the groups table. */
mysqli_query($dbconn, $makeGroupTable);

$dropBenchTable = "DROP TABLE bench"; /**< SQl query to drop the bench table. */
mysqli_query($dbconn, $dropBenchTable);
$makeBenchTable = "CREATE TABLE bench SELECT * FROM bench_temp"; /**< SQl query to copy the temporary bench table to the bench table. */
mysqli_query($dbconn, $makeBenchTable);

$dropRoomLetterTable = "DROP TABLE room_letter"; /**< SQl query to drop the room_letter table. */
mysqli_query($dbconn, $dropRoomLetterTable);
$makeRoomLetterTable = "CREATE TABLE room_letter SELECT * FROM room_letter_temp"; /**< SQl query to copy the temporary room_letter table to the room_letter table. */
mysqli_query($dbconn, $makeRoomLetterTable);

$dropRoomsTable = "DROP TABLE rooms"; /**< SQl query to drop the rooms table. */
mysqli_query($dbconn, $dropRoomsTable);
$makeRoomsTable = "CREATE TABLE rooms SELECT * FROM rooms_temp"; /**< SQl query to copy the temporary rooms table to the rooms table. */
mysqli_query($dbconn, $makeRoomsTable);


echo '<script type="text/javascript">alert("The database was updated successfully"); </script>';

?>
