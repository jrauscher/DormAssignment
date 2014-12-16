<?php
    include ('../includes/svrConnect.php');

$dropStudentsTable = "DROP TABLE students";
mysqli_query($dbconn, $dropStudentsTable);
$makeStudentsTable = "CREATE TABLE students SELECT * FROM students_temp";
mysqli_query($dbconn, $makeStudentsTable);

$dropGroupTable = "DROP TABLE groups";
mysqli_query($dbconn, $dropGroupTable);
$makeGroupTable = "CREATE TABLE groups SELECT * FROM groups_temp";
mysqli_query($dbconn, $makeGroupTable);

$dropBenchTable = "DROP TABLE bench";
mysqli_query($dbconn, $dropBenchTable);
$makeBenchTable = "CREATE TABLE bench SELECT * FROM bench_temp";
mysqli_query($dbconn, $makeBenchTable);

$dropRoomLetterTable = "DROP TABLE room_letter";
mysqli_query($dbconn, $dropRoomLetterTable);
$makeRoomLetterTable = "CREATE TABLE room_letter SELECT * FROM room_letter_temp";
mysqli_query($dbconn, $makeRoomLetterTable);

$dropRoomsTable = "DROP TABLE rooms";
mysqli_query($dbconn, $dropRoomsTable);
$makeRoomsTable = "CREATE TABLE rooms SELECT * FROM rooms_temp";
mysqli_query($dbconn, $makeRoomsTable);


echo '<script type="text/javascript">alert("The database was updated successfully"); </script>';

?>
