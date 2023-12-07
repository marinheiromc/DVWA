<?php

if (isset($_REQUEST['Submit'])) {
	// Get input
	$id = $_REQUEST['id'];

	switch ($_DVWA['SQLI_DB']) {
		case MYSQL:
			// Check database using prepared statement
			$query  = "SELECT first_name, last_name FROM users WHERE user_id = ?";
			$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query);
			mysqli_stmt_bind_param($stmt, 's', $id);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			// Get results
			while ($row = mysqli_fetch_assoc($result)) {
				// Get values
				$first = $row["first_name"];
				$last  = $row["last_name"];

				// Feedback for end user
				$html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
			}

			mysqli_close($GLOBALS["___mysqli_ston"]);
			break;

		case SQLITE:
			global $sqlite_db_connection;

			// Check database using prepared statement
			$query  = "SELECT first_name, last_name FROM users WHERE user_id = ?";
			$stmt = $sqlite_db_connection->prepare($query);
			$stmt->bindValue(1, $id, SQLITE3_TEXT);
			$results = $stmt->execute();
			// check vul
echo "Alas";
			if ($results) {
				while ($row = $results->fetchArray()) {
					// Get values
					$first = $row["first_name"];
					$last  = $row["last_name"];

					// Feedback for end user
					$html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
				}
			} else {
				echo "Error in fetch " . $sqlite_db->lastErrorMsg();
			}
			break;
	}
}

?>
