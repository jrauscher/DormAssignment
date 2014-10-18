<?php

/* Displays erros to browser */
ini_set('display_errors', true);

/* Connect to database: host, username, password, database name. */
/* If you're using multiple PHP files that need a database connection, you must reconnect on each of the pages. */
$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNODB');

if( !$dbconn ){
    die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
}

$was_errors = false;
$errors = array();
$room = _$GET["room"];

/* Set up your query in a string. */
$getStudentsFromRoom = "SELECT build_id FROM rooms WHERE " . $room . " = 101";

$result = mysqli_query($dbconn, $getStudentsFromRoom);

printResultTable($result);
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
                echo '<p class="bg-info text-info text-center large">No results found.<    /p>';
            }
        } else { /* There was a syntax error in your SQL! */
            echo 'Query not successful.';
        }
}
?>
<br/><br/><br/><br/>
</div>

