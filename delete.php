<?php
	session_start();
	// connect to the database
	include('includes/dbh.inc.php');
	
	// confirm that the 'id' variable has been set
	if (isset($_POST['deleteData']))
	{
		// get the 'id' variable from the URL
		$id = $_POST['id'];
		$reasonToDelete = $_POST['reasonToDelete'];
		$userName = $_SESSION["username"];

		// Copy old record to delete logs
		if ($stmt = $conn->prepare("INSERT INTO deletelogs (masterlistID, lastName, firstName, addressLocation, boxNumber, remarks, dateOfPurchase, contact, installer)
		SELECT id, lastName, firstName, addressLocation, boxNumber, remarks, dateOfPurchase, contact, installer
		FROM gpinoy
		WHERE id = ?;"))
		{
			$stmt->bind_param("i",$id);	
			$stmt->execute();
			$stmt->close();
		}

		// Insert timestamp, reason and username
		if ($stmt = $conn->prepare("UPDATE deletelogs SET dateAndTime=now(), info=?, userName=? WHERE masterlistID=?"))
		{
			$stmt->bind_param("ssi",$reasonToDelete, $userName, $id);	
			$stmt->execute();
			$stmt->close();
		}
		
		// delete record from database
		if ($stmt = $conn->prepare("DELETE FROM gpinoy WHERE id = ? LIMIT 1"))
		{
			$stmt->bind_param("i",$id);	
			$stmt->execute();
			$stmt->close();
		}
		else
		{
			echo "ERROR: could not prepare SQL statement.";
		}
		$conn->close();
	

		// redirect user after delete is successful
		header("Location: index.php");
	}
	/*else
	// if the 'id' variable isn't set, redirect the user
	{
		header("Location: index.php");
	}*/


/*$started = microtime(true);	
//Record the end time after the query has finished running.
$end = microtime(true);

//Calculate the difference in microseconds.
$difference = $end - $started;

//Format the time so that it only shows 10 decimal places.
$queryTime = number_format($difference, 10);

//Print out the seconds it took for the query to execute.
echo "SQL query took $queryTime seconds.";	*/