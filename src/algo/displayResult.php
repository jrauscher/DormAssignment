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


// PRINTS OUT GROUPS TABLE
$groups = "SELECT * FROM groups";

$result = mysqli_query($dbconn, $groups);
?>

<link rel="stylesheet" type="text/css" href="table.css">

<?php
printResultTable($result);
function printResultTable($res){
		$count = 0;
		$group = 0;
		if($res){
			//echo 'Query successful.';
			/* Check to see if at least 1 row was returned. */
			/* CAREFUL: If using an update query, this will still return 0 even if a row was updated. */
			if( mysqli_num_rows($res) > 0){
				/* Start printing (echo) the table to the user. */
				echo '<table align="center" id="mytable" class="mytable">';

				/* Use the first row to get the table headers. */
				$first_row = mysqli_fetch_assoc($res);
				foreach($first_row as $col => $val){ /* Don't care about the $val here, but have to have it to get the $col */

					echo '<th>';
					echo $col;
					echo '</th>';
				}
				echo '</tr>';
				echo '<tbody>';
				/* Make sure to reset the pointer back to beginning if you've used the result before. */
				mysqli_data_seek($res, 0);
				while( $row = mysqli_fetch_assoc($res) ){ /* mysqli_fetch_assoc will return each row until all rows have been read. Once it's done, it returns false. */
					if($count == 4){
						$group -= 3;
						echo '<th>';
						echo '<br/>GROUP'.$group.'<br/>';
						echo '</th>';
						$count = 0;	
					}
					echo '<tr>';
					foreach($row as $val){ /* Loop through array, each item in array gets assigned to $val */
						echo '<td>';
						echo $val;
						echo '</td>';
					} 
					echo '</tr>';
					$count ++;
					$group ++;
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
