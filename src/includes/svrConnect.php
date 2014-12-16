<?php
ini_set('display_errors', true);
$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNVDB');

if( !$dbconn ){
    die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
}
?>
