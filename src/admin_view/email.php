<?php
	include ('../includes/svrConnect.php');

$was_errors = false; /**< Set to True if errors were found. */
$errors = array(); /**< Stores a array of the error that occurs. */ 

/* Set up your query in a string. */
$sqlEmailTable = "SELECT needs_email AS 'Email?', student_id AS 'Student ID', username AS 'Username', building_name AS 'Complex Name' FROM users"; /**< Default Query used to get student information for the emails table when username is not passed. */
$sqlEmailTable2 = "SELECT student_id AS 'Student ID', username AS 'Username', building_name AS 'Complex Name' FROM users"; /**< Query is used if a username is passed to populate emails tables. */
$building_names = "SELECT DISTINCT building_name FROM building"; /**< Query used to get a list of building names. */
$better = 0; /**< Used to figure out which Query to use, set to 1 if a username is passed. */

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
	else if($_GET['sort'] == 'Email?')
	{
		$sqlEmailTable .= " ORDER BY needs_email";
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

include ('../includes/header.html');
?>
<head>
   <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
   <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
   <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<script type="text/javascript "src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="/packages/jquery.tablesorter.js"></script>
</head>

<div class ="content2">
	<div id = "home">
		<div id="welcome"> 
			<link rel="stylesheet" type="text/css" href="table.css">
			<!-- Form for user to enter information. -->
		<br/>
	
			<form action="" method="post">
				<table>
					<tr>
						<th><label for="username">Search for user(by username):</label>
		    			<th><input name="username" /></th>
			    		<th><input class="button1" type="submit" value="Submit" /></th>
					</tr>
				<table>
			</form>
			<br/>

			<form action="validate/sendMail.php" method="post">
				<table>
					<tr>
						<th style="text-align:left"><label for="username">Email:</label>
					</tr>
					<tr style="text-align:left">
						<th>&nbsp;&nbsp;&nbsp;&nbsp;Title: <input type="text" name="title" style="width: 600px"></th>
					</tr>
					<tr>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;Manual Recipiant: <input type="text" name="recip" style="width: 425px"></th>
					</tr>	
					<tr style="text-align:left">
						<th>&nbsp;&nbsp;&nbsp;&nbsp;Body:<br/><textarea name="body" rows="6" cols="100"></textarea></th>
					</tr>	
					<tr style="text-align:right">
						<th><input class="button1" type="submit" value="Send" /></th>
					</tr>
				</table>
			<br/><br/> 

<?php

/** Used to make sure the username variable is set to a value before using it. */
if( isset($_POST['username']) && $_POST['username'] != null && $_POST['username'] != '' ){
     $sqlEmailTable2 .= ' WHERE username = "' . mysqli_real_escape_string($dbconn,$_POST['username']) .'"';
	 $better = 1;
}

$limit = 0; 
/**
* Checks to see if there is a limit set on the table and limits the table based on that.
*/
if(isset($_GET['limit']))
{
	echo '<input type="hidden" value="'.$_GET['limit'].'" name="limit"/>';
	$limit = $_GET['limit'];
	$limit2 = $limit + 10;
	$limit3 = $limit - 10;

	echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '&nbsp;&nbsp;';
	
	if($limit > 0)
	{
/**
* Checks to see if there is a sort variable and sorts the table if there is one based on the variable passed.
*/
		if(isset($_GET['sort']))
		{
		if($_GET['order'] == 'asc')
		{
			echo'<a class="button1" href="email.php?tab=emails&sort=';
			echo $_GET['sort'];
			echo'&order=asc&limit=';
			echo $limit3;
			echo '">Prev 10</a>';
		}
		else
		{
			echo '<a class="button1" href="email.php?tab=emails&sort=';	
			echo $_GET['sort'];
			echo '&order=desc&limit=';
			echo $limit3;
			echo '">Prev 10</a>';
		}
		}
		else
		{
			echo '<a class="button1" href="email.php?tab=emails&limit=';
			echo $limit3;
			echo '">Prev 10</a>';
		}
	}
/**
* Checks to see if there is a sort variable and sorts the table if there is one based on the variable passed.
*/
	if(isset($_GET['sort']))
	{
		if($_GET['order'] == 'asc')
		{
			echo'<a class="button1" href="email.php?tab=emails&sort=';
			echo $_GET['sort'];
			echo'&order=asc&limit=';
			echo $limit2;
			echo '">Next 10</a>';
		}
		else
		{
			echo'<a class="button1" href="email.php?tab=emails&sort=';
			echo $_GET['sort'];
			echo'&order=desc&limit=';
			echo $limit2;
			echo '">Next 10</a>';
		}
	}
	else
	{
		echo'<a class="button1" href="email.php?tab=emails&limit=';
		echo $limit2;
		echo '">Next 10</a>';
	}
	echo '<br/><br/>';
	$result_1 = mysqli_query($dbconn, $sqlEmailTable);
}
else
{
	$sqlEmailTable.= " LIMIT 0, 10";
	echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '&nbsp;&nbsp;';
	if(isset($_GET['sort']))
	{
		if($_GET['order'] == 'asc')
		{
			echo '<a class="button1" href="email.php?tab=emails&sort=';
			echo $_GET['sort'];
			echo'&order=asc&limit=10">Next 10</a>';
		}
		else
		{
			echo '<a class="button1" href="email.php?tab=emails&sort=';
			echo $_GET['sort'];
			echo '&order=desc&limit=10">Next 10</a>';
		}
	}
	else
	{
		echo '<a class="button1" href="email.php?tab=emails&limit=10">Next 10</a>';
	}
	echo '<br/><br/>';
	$result_1 = mysqli_query($dbconn, $sqlEmailTable);
}

if($better == 1){
     $result_1 = mysqli_query($dbconn, $sqlEmailTable2);
}

$result_2 = mysqli_query($dbconn, $building_names);
?>
<p><font size=3>Select users to send emails to:</font>
</div></div>

<?php
printResultTable($result_1);
echo '</form>';
/**
*<pre>
PRINTRESULTTABLE: Prints a table based on the SQL Query result passed to it.
TAKES: Takes a SQL Query result.
RETURNS: A table that is based on the SQL Query result.
</pre> 
*/
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
				foreach($first_row as $col => $val){ /* Don't care about the $val here, but have to have it to get the $col */
					echo '<th>';

					echo '<a href="email.php?tab=emails&sort=';
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
					if(isset($_GET['limit']))
					{
						echo '&limit=';
						echo $_GET['limit'];
					}
					echo '" class="sortedTable">';
					echo $col;
					echo '</a>';
					echo ' ';
					echo '<a href="email.php?tab=emails&sort=';
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
					if(isset($_GET['limit']))
					{
						echo '&limit=';
						echo $_GET['limit'];
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
					foreach($row as $val){ /* Loop through array, each item in array gets assigned to $val */
						if($count == 0)
						{
							if($val=='0')
							{
								echo '<tr bgcolor="#3366FF">';
							}
							else
							{
								echo '<tr>';
							}
							$count = 4;
							$count2++;
						}
						echo '<td>';
						if($count == 4){
							echo '<input type="hidden" value="0" name="chk'.$count2.'"/>';
							echo '<input type="checkbox" value="'.$val.'" name="chk'.$count2.'"/>';
						}
						elseif($count == 3){
							echo '<input type="hidden" value="'.$val.'" name="stdID'.$count2.'"/>';
							echo $val;
						}
						else{
							echo $val;
						}
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
