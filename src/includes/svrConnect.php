<?php
ini_set('display_errors', true);
$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNODB'); /**< Used to connect to the database so you can run SQL Query's, this is shared across all php files. */

if( !$dbconn ){
    die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
}
?>
