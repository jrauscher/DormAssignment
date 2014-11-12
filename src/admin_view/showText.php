<head>
    <script type="text/javascript" src="java-script/newWindow.js"></script>
    <link rel="stylesheet" href="../css/table.css" type="text/css">
</head>
<?php
include ('../includes/svrConnect.php');
$st_id = $_GET['st_id'];
$cell_id = $_GET['cell_id'];
$length = $_GET['length'];


$st_id = mysql_real_escape_string($st_id);
$cell_id = mysql_real_escape_string($cell_id);
$length = mysql_real_escape_string($length);

$query = "SELECT comments FROM students WHERE student_id = '$st_id'";
$query_result = mysqli_query($dbconn, $query);

while($row = mysqli_fetch_assoc($query_result))
{
    foreach($row as $comments)
    {
		if($length == 0) //shortened
		{	
			echo '<div style="white-space:nowrap; text-overflow: ellipsis; overflow: hidden; height:100%; width:100%;" onclick="displayText(' . $st_id . ',' . $cell_id . ',1);">';
			//$temp = substr($comments,0,50);
			echo $comments;
			echo '</div>';
		}
		else //full text
		{
			echo '<div style="white-space:pre-wrap; overflow:hidden; height:100%; width:100%;" onclick="displayText(' . $st_id . ',' . $cell_id . ',0);">';
        	echo $comments;
			echo '</div>';
		}
    }
}
?>

