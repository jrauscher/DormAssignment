<?php

/* Displays erros to browser */
ini_set('display_errors', true);

/* Connect to database: host, username, password, database name. */
/* If you're using multiple PHP files that need a database connection, you must reconnect on each of the pages. */
$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNODB');

if( !$dbconn ){
    die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
}

/* Set up your query in a string. */
$buildings = "SELECT building_name FROM building";
$NUIDs = "SELECT student_id FROM students";

/* Add a where clause if user has entered some data. */
if( isset($_POST['NUID_search']) && is_numeric($_POST['NUID_search']) && $_POST['NUID_search'] != null && $_POST['NUID_search'] != '' ){
    $NUIDs .= ' WHERE student_id  = ' . mysqli_real_escape_string($dbconn, $_POST['NUID_search']);
}

/* Send query to database. */
$result = mysqli_query($dbconn, $NUIDs);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to the View Page</title><!-- This title shows up in the broswer tab. -->
</head>
		 <script type="text/javascript" src="mktree.js"></script>
        	<link rel="stylesheet" href="mktree.css" type="text/css">
<style type="text/css">

#body {
    border:                 0px;
    margin:                 0px;
    padding:                0px;
    font-family:            "Times New Roman", serif;
    background-color:       #ccd;
}

#a {
    color:                  #070;
    text-decoration:        underline;
}

#header {
    width:                  300px;
    position:               fixed;
    top:                    0px;
    left:                   0px;
    bottom:                 0px;
    padding:                0px;
    background-color:       #aab;
    border-right:           2px solid #900;
}

#title {
    margin:                 14px;
    font-weight:            bold;
    font-size:              1.2em;
}

#nav {
    border-bottom:          2px solid #900;
}

#nav a {
    padding:                .1em 0px .25em 15px; // top rt bot lt
    white-space:            nowrap;
    display:                block;
    border-top:             1px solid #855;
    background-color:       #bab;
    font-weight:            bold;
    text-decoration:        none;
}

#nav a:hover {
    background-color:       #dab;
}

#content {
    margin-left:            302px;
    padding:                1em;
    max-width:              500px;
}

.page {
    border:                 1px solid black;
    margin-bottom:          3em;
    padding:                1em;
    background-color:       #eee;
}
.pagenum {
    font-size:              75%;
    text-align:             center;
}
.heading {
    font-weight:            bold;
}

</style>

<body>
<div id="header">

<div id="title">
	Tree Thingy
</div>

<?php
$campus = "SELECT DISTINCT campus FROM building";
$building_names = "SELECT building_name FROM building";
$building_letters = "SELECT building_letter FROM building";
$room_number = "SELECT * FROM building, rooms WHERE building.build_id = "; 
$result_campus = mysqli_query($dbconn, $campus . ";");



echo '<ul class="mktree" id="tree">';
echo '<li class="liClosed"><font size="5">Campus</font>';
while ($campus_name = mysqli_fetch_assoc($result_campus))
{
	echo '<ul>';
	foreach($campus_name as $campus_val)
	{
	echo '<li class="liClosed">' . $campus_val;
	$result_building_names = mysqli_query($dbconn, $building_names . " WHERE campus = '" . $campus_val . "';");
	while ($building_name = mysqli_fetch_assoc($result_building_names))
	{
		echo '<ul>';
		foreach($building_name as $building_val)
		{
		echo '<li class="liClosed">' . $building_val;
		//$result_building_letters = mysqli_query($dbconn, $building_letters . " WHERE building_names = '" . $building_val . "';"); need to get building id not name
		/*while ($building_letter = mysqli_fetch_assoc($building_letters))
		{
			echo '<ul>';
			
			echo '</ul>'; //building name ul
		}
		*/echo '</li>'; //building name li
		}
		echo '</ul>'; //campus name ul
	}
	echo '</li>'; //campus name li
	}
	echo '</ul>'; //Campus ul
}
echo '</li>'; //Campus li
echo '</ul>'; //tree

?>
<!--<ul class="mktree" id="tree1">
	<li class="liOpen"><font size="5">Campus</font>
		<ul>
			<li class="liClosed">North
				<ul>
					<li>Stuff</li>
				</ul>
			</li>
			<li class="liClosed">South
				<ul>
					<li class="liClosed">Scott Hall
						<ul>
							<li class="liClosed">Building 1
								<ul>
									<li class="liClosed">Floor 1
										<ul>
											<li class="liClosed"><a href="#Room102">Room 102</a>
											</li>
										</ul>
									</li>
									<li class="liClosed">Floor 2
										<ul>
										</ul>
									</li>
									<li class="liClosed">Floor 3
										<ul>
										</ul>
									</li>
									<li class="liClosed">Floor 4
										<ul>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li class="liClosed">Scott Village
						<ul>
						</ul>
					</li>
					<li class="liClosed">Scott Court
						<ul>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</li>	
</ul>
-->
</div>


<div id="content">



		<!-- Form for user to enter information. -->
		<form action="" method="post">
			<label for="NUID_search">Search for contact(by name): </label>
			<input name="NUID_search" />

			<input type="submit" value="Submit" />
		</form>

		<?php
		/* SQL result will be false if a SQL syntax error exists. */
		if($result){
			echo 'Query successful.';
			/* Check to see if at least 1 row was returned. */
			/* CAREFUL: If using an update query, this will still return 0 even if a row was updated. */
			if( mysqli_num_rows($result) > 0){
				/* Start printing (echo) the table to the user. */
				echo '<table>';

				/* Use the first row to get the table headers. */
				$first_row = mysqli_fetch_assoc($result);
				echo '<tr>';				
				foreach($first_row as $col => $val){ /* Don't care about the $val here, but have to have it to get the $col */
					echo '<th>';
					echo $col;
					echo '</th>';
				}
				echo '</tr>';

				/* Make sure to reset the pointer back to beginning if you've used the result before. */
				mysqli_data_seek($result, 0);
				while( $row = mysqli_fetch_assoc($result) ){ /* mysqli_fetch_assoc will return each row until all rows have been read. Once it's done, it returns false. */
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
				echo '<br /> No results found.';
			}
		} else { /* There was a syntax error in your SQL! */
			echo 'Query not successful.';
		}
		?>
</div>

</body>
</html>

