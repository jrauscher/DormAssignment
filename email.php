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
$sqlEmailTable = "SELECT student_id AS 'Student ID', username AS 'Username', building_name AS 'Complex Name' FROM users ORDER BY student_id";
$building_names = "SELECT DISTINCT building_name FROM building";

$result_1 = mysqli_query($dbconn, $sqlEmailTable);
$result_2 = mysqli_query($dbconn, $building_names);

include ('includes/header.html');
?>

<div id = "subform"> 
			<script type="text/javascript" src="/packages/jquery-latest.js"></script>
			<script type="text/javascript" src="/packages/jquery.tablesorter.js"></script>
			<link rel="stylesheet" type="text/css" href="table.css">
			<!-- Form for user to enter information. -->
			<h2>Create a User</h2>
			
			<form action="validate/userVal.php" method="post">
     			<table class = "Nothing">
     				<tr>
       					<th align="right">NU ID:</th>
      		 			<th><input name="NUID" type="text" required></input></th>
     				    <th align="right">Email:</th>
       					<th><input name="email" type="email" required></input></th>
    				 </tr>
				     <tr>
				        <th align="right">Complex Name:</th>
						<th align="left">
							<select name="complex">
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
					</tr>
					<tr>
						<th align="right"> <input class="btn btn-primary btn-xs" type="submit" value="Submit" /></th>
					</tr>
			</th>
				</table>
			</form>		

<br/><br/><br/>


<?php
printResultTable($result_1);
function printResultTable($res){
		$count = 0;
		if($res){
			//echo 'Query successful.';
			/* Check to see if at least 1 row was returned. */
			/* CAREFUL: If using an update query, this will still return 0 even if a row was updated. */
			if( mysqli_num_rows($res) > 0){
				/* Start printing (echo) the table to the user. */
				echo '<table align="center" id="mytable" class="mytable">';


				/* Use the first row to get the table headers. */
				$first_row = mysqli_fetch_assoc($res);
				echo '<thead>';
				echo '<tr>';			
				echo '<th>';
				echo '';
				echo '</th>';	
				foreach($first_row as $col => $val){ /* Don't care about the $val here, but have to have it to get the $col */
					echo '<th>';
					echo $col;
					echo '</th>';
				}
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				/* Make sure to reset the pointer back to beginning if you've used the result before. */
				mysqli_data_seek($res, 0);
				while( $row = mysqli_fetch_assoc($res) ){ /* mysqli_fetch_assoc will return each row until all rows have been read. Once it's done, it returns false. */
					echo '<tr>';
					echo '<td style="text-aslign:center;">';
					echo '<input type="checkbox" id="rowId'.$count.'"">';
					echo '</td>';
					foreach($row as $val){ /* Loop through array, each item in array gets assigned to $val */
						echo '<td>';
						echo $val;
						echo '</td>';
					} 
					$count++;
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
</div>

<?php
include ('includes/footer.html');
?>
