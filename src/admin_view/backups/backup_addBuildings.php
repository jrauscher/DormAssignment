<?php
function escape($conn, $string){
	return mysqli_real_escape_string($conn, $string);
}
function h($string){
	return htmlspecialchars($string);
}
/* Use this if you're on loki. Loki is set to not show errors, which makes it difficult to debug. */
ini_set('display_errors', true);

/* Connect to database: host, username, password, database name. */
/* If you're using multiple PHP files that need a database connection, you must reconnect on each of the pages. */
$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNODB');

if( !$dbconn ){
    die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
}

$was_errors = false;
$errors = array();

/* Set up your query in a string. */
$sql_1 = "SELECT build_id AS ID, building_name AS 'Building Name', building_letter AS Letter, campus AS Campus, num_rooms AS 'Number of Rooms', floor AS Floors, lease AS 'Lease Type', RA_rooms AS 'RA Rooms', handicapped_rooms AS 'Handicapped Rooms' FROM building";
$campus = "SELECT DISTINCT campus FROM building";

$result_1 = mysqli_query($dbconn, $sql_1);
$result_2 = mysqli_query($dbconn, $campus);

include ('includes/header.html');
?>
<div id = "subform"> 
			<link rel="stylesheet" type="text/css" href="table.css">
			<!-- Form for user to enter information. -->
			<h2 id="contact">Add a Building</h2>
			<br/><br/>
			
			<form action="validate/buildingVal.php" method="post">
     			<table class = "Nothing">
					<tr>
       					<th align="right">Building Name:</th>
       					<th><input name="bName" type="text" required></input></th>
       					<th align="right">Letter:</th>
       					<th><input name="letter" type="text"></input></th>
       					<th align="right">Campus:</th>
						<th align="left">				
							<select name="campus">
							<?php
								while( $row = mysqli_fetch_assoc($result_2) ){
									foreach($row as $val){
										echo '<option value="'.$val.'">';
										echo $val;
										echo '</option>';
									}	
								}
							?>
							</select>
						</th>
       					<th align="right">Number of Rooms:</th>
       					<th><input name="rnum" type="text" required></input></th>
					</tr>
					<tr>
       					<th align="right">Number of Floors:</th>
       					<th><input name="fnum" type="text" required></input></th>
       					<th align="right">Lease Type:</th>
       					<th><input name="lease" type="text" required></input></th>
       					<th align="right">Number of RA Rooms:</th>
       					<th><input name="raNum" type="text" required></input></th>
       					<th align="right">Number of Handicapped Rooms:</th>
       					<th><input name="hcNum" type="text" required></input></th>
     				</tr>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th align="right"> <input class="btn btn-primary btn-xs" type="submit" value="Submit" /></th>
					</tr>
				</table>
			</form>		

<br/><br/><br/>


<?php
printResultTable($result_1);
function printResultTable($res){
		if($res){
			//echo 'Query successful.';
			/* Check to see if at least 1 row was returned. */
			/* CAREFUL: If using an update query, this will still return 0 even if a row was updated. */
			if( mysqli_num_rows($res) > 0){
				/* Start printing (echo) the table to the user. */
				echo '<table class="mytable">';


				/* Use the first row to get the table headers. */
				$first_row = mysqli_fetch_assoc($res);
				echo '<tr>';				
				foreach($first_row as $col => $val){ /* Don't care about the $val here, but have to have it to get the $col */
					echo '<th>';
					echo $col;
					echo '</th>';
				}
				echo '</tr>';

				/* Make sure to reset the pointer back to beginning if you've used the result before. */
				mysqli_data_seek($res, 0);
				while( $row = mysqli_fetch_assoc($res) ){ /* mysqli_fetch_assoc will return each row until all rows have been read. Once it's done, it returns false. */
					echo '<tr>';
					foreach($row as $val){ /* Loop through array, each item in array gets assigned to $val */
						echo '<td>';
						echo $val;
						echo '</td>';
					}
					echo '</tr>';
				}

				echo '</table>';
			} else { /* Number of rows is < 1 */
				echo '<p class="bg-info text-info text-center large">No results found.</p>';
			}
		} else { /* There was a syntax error in your SQL! */
			echo 'Query not successful.';
		}
}
?>

</div>

<?php
include ('includes/footer.html');
?>
