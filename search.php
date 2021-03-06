<html>
<title>Inquire</title>
<link rel="icon" href="logo.png" />
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<body>

<form class="navbar-form navbar-left" role="search" action="search.php">
  <div class="form-group">
    <input type="text" class="form-control" placeholder="Inquire" name="hashtag">
  </div>
  <button type="submit" class="btn btn-default">Sanction</button>
</form>
<br />
<br />
<br />

	<?php

	    // pass in some info;
		require("common.php");

		if(empty($_SESSION['user'])) {

			// If they are not, we redirect them to the login page.
			$location = "http://" . $_SERVER['HTTP_HOST'] . "/login.php";
			echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
			//exit;

        	// Remember that this die statement is absolutely critical.  Without it,
        	// people can view your members-only content without logging in.
        	die("Redirecting to login.php");
    	}

		// To access $_SESSION['user'] values put in an array, show user his username
		$arr = array_values($_SESSION['user']);
		$user = $arr[1];
		$user_search = array_values($_SESSION['hashtag']);
		echo $user_search;
		echo "<h2>Welcome to InstantGramme <span class='label label-default'>" . $user . "</span> </h2>";

		// open connection
		$connection = mysqli_connect($host, $username, $password) or die ("Unable to connect!");

		// select database
		mysqli_select_db($connection, $dbname) or die ("Unable to select database!");

		// create query
		$query = "SELECT * FROM symbols";
		$search = "SELECT animals FROM symbols LIKE %$user_search%";

		// execute query
		$result = mysqli_query($connection,$query) or die ("Error in query: $query. ".mysql_error());

		// see if any rows were returned
		if (mysqli_num_rows($search) > 0) {

    		// print them one after another
    		echo "<table class=table table-bordered>";
				echo "    <thead>
      <tr>
        <th>Raster Representation of User</th>
        <th>Alias Surname</th>
        <th>Memorandums</th>
      </tr>
    </thead>";
    		while($row = mysqli_fetch_row($result)) {
        		echo "<tr>";
				echo "<td>".$row[0]."</td>";
        		echo "<td><span class='label label-default'>" . $row[1]."</span></td>";
        		echo "<td>".$row[2]."</td>";
				// echo "<td><a href=".$_SERVER['PHP_SELF']."?id=".$row[0].">Delete</a></td>";
        		echo "</tr>";
    		}
		    echo "</table>";

		} else {

    		// print status message
    		echo "No rows found!";
		}

		// free result set memory
		mysqli_free_result($connection,$result);

		// set variable values to HTML form inputs
		$country = $_POST['country'];
    	$animal = $_POST['animal'];

		// check to see if user has entered anything
		if ($animal != "") {
	 		// build SQL query
			$query = "INSERT INTO symbols (country, animal) VALUES ('$user', '$animal')";
			// run the query
     		$result = mysqli_query($connection,$query) or die ("Error in query: $query. ".mysql_error());
			// refresh the page to show new update
	 		echo "<meta http-equiv='refresh' content='0'>";
		}

		// if DELETE pressed, set an id, if id is set then delete it from DB
		if (isset($_GET['id'])) {

			// create query to delete record
			echo $_SERVER['PHP_SELF'];
    		$query = "DELETE FROM symbols WHERE id = ".$_GET['id'];

			// run the query
     		$result = mysqli_query($connection,$query) or die ("Error in query: $query. ".mysql_error());

			// reset the url to remove id $_GET variable
			$location = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
			exit;

		}

		// close connection
		mysqli_close($connection);

	?>

		<br />
		<br />
    <!-- This is the HTML form that appears in the browser -->

	</body>
</html>
