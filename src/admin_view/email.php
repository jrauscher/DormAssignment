<?php
	include ('../includes/svrConnect.php');

$was_errors = false;
$errors = array();

/* Set up your query in a string. */
$sqlEmailTable = "SELECT student_id AS 'Student ID', username AS 'Username', building_name AS 'Complex Name' FROM users";
$building_names = "SELECT DISTINCT building_name FROM building";



if(isset($_GET['sort'])){
	if($_GET['sort'] == 'Student ID')
	{
		$sqlEmailTable .= " ORDER BY student_id";
	}
	else if($_GET['sort'] == 'Username')
	{
		$sqlEmailTable .= " ORDER BY username";
	}
	else if($_GET['sort'] == 'Complex Name')
	{
		$sqlEmailTable .= " ORDER BY building_name";
	}
}
if(isset($_GET['order']))
{
	if($_GET['order'] == 'asc')
	{
		$sqlEmailTable .= " ASC";
	}
	else if ($_GET['order'] == 'desc')
	{
		$sqlEmailTable .= " DESC";
	}
}
if(isset($_GET['limit']))
{
	$sqlEmailTable.= " LIMIT ".$_GET['limit']." , 10";
}
$result_1 = mysqli_query($dbconn, $sqlEmailTable);
$result_2 = mysqli_query($dbconn, $building_names);

include ('../includes/header.html');
?>
<head>
	<script type="text/javascript "src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="/packages/jquery.tablesorter.js"></script>
</head>
<div class ="content2">
<div id = "home">
	<div id="welcome"> 
			<link rel="stylesheet" type="text/css" href="table.css">
			<!-- Form for user to enter information. -->
	<br/>
			
			<form action="validate/sendMail.php" method="post">
				<p style="padding-left:20px">
				Title: <input type="text" name="title" style="width: 600px"><br><br>
				Body:<br/> <textarea name="body" rows="6" cols="100"></textarea><br>
       			<font size=3>Select users to send emails to:</font>
				<br/><br/>
				<input class="button1" type="submit" value="Send" /></p> 
</div></div>
<br/><br/> 

<?php
$limit = 0; 
if(isset($_GET['limit']))
{
	$limit = $_GET['limit'];
	$limit2 = $limit + 10;
	$limit3 = $limit - 10;
	echo'<a align="center" class="button1" href="email.php?tab=three&limit=';
	echo $limit2;
	echo '"> Next </a>';
	if($limit > 0)
	{
		echo '<a aligne"center" class="button1" href="email.php?tab=three&limit=';
		echo $limit3;
		echo '"> Prev </a>';
	}
}
else
{
	echo '<a align="center" class="button1" href="email.php?tab=three&limit=10"> Next </a>';
}
?>

<?php
printResultTable($result_1);
echo '</form>';
function printResultTable($res){
		$count = 0;
		$count2 = 0;
		if($res){
			//echo 'Query successful.';
			/* Check to see if at least 1 row was returned. */
			/* CAREFUL: If using an update query, this will still return 0 even if a row was updated. */
			if( mysqli_num_rows($res) > 0){
				/* Start printing (echo) the table to the user. */
				echo '<table id="MyTable" class="mytable">';

				/* Use the first row to get the table headers. */
				$first_row = mysqli_fetch_assoc($res);
				echo '<thead>';
				echo '<tr>';			
				echo '<th>';
				echo '';
				echo '</th>';
				foreach($first_row as $col => $val){ /* Don't care about the $val here, but have to have it to get the $col */
					echo '<th>';

					echo '<a href="email.php?tab=three&sort=';
					echo $col;
					if(isset($_GET['order']))
					{
						if($_GET['order'] == 'asc')
						{
							echo '&order=desc';
						}
						else
						{
							echo '&order=asc';
						}
					}
					else
					{
						echo '&order=desc';
					}
					echo '" class="sortedTable">';
					echo $col;
					echo '</a>';
					echo ' ';
					echo '<a href="email.php?tab=three&sort=';
					echo $col;
					if(isset($_GET['order']))
					{
						if($_GET['order'] == 'asc')
						{
							echo '&order=desc';
						}
						else
						{
							echo '&order=asc';
						}
					}
					else
					{
						echo '&order=desc';
					}
					echo '" class="sortedTable">';	
					if(isset($_GET['order'])&& isset($_GET['sort']) && $_GET['sort']==$col )
					{
						if($_GET['order'] == 'asc')
						{
							echo '&#8679;';
						}
						else
						{
							echo '&#8681;';
						}
					}
					else
					{
						echo '';
					}
					echo '</a>';		
					echo '</th>';
				}
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				/* Make sure to reset the pointer back to beginning if you've used the result before. */
				mysqli_data_seek($res, 0);
				while( $row = mysqli_fetch_assoc($res) ){ /* mysqli_fetch_assoc will return each row until all rows have been read. Once it's done, it returns false. */
					echo '<tr>';
					foreach($row as $val){ /* Loop through array, each item in array gets assigned to $val */
						if($count == 0)
						{
							echo '<td style="text-aslign:center;">';
							echo '<input type="hidden" value="'.$val.'" name="stdID'.$count2.'"/>';
							echo '<input type="hidden" value="0" name="chk'.$count2.'"/>';
							echo '<input type="checkbox" value="1" name="chk'.$count2.'"/>';
							echo '</td>';
							$count = 3;
							$count2++;
						}
						echo '<td>';
						echo $val;
						echo '</td>';
					$count--;
					} 
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
			} else { /* Number of rows is < 1 */
				echo '<p class="bg-info text-info text-center large">No results found.</p>';
			}
		} else { /* There was a syntax error in your SQL! */
			echo 'Query not successful.';
		}
}
?>

<br/><br/><br/><br/>

<?php
include ('../includes/footer.html');
?>
