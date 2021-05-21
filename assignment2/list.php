<?php

include "db.php";

try {
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$stmt = $conn->prepare("SELECT * FROM myguestbook");
	$stmt->execute();

	$result = $stmt->fetchAll();

}
catch(PDOException $e)
{
	echo "Error: " . $e->getMessage();
}

$conn = null;
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Guestbook</title>
</head>
<body>

	<ol>
		<?php
		foreach($result as $row) {
			$fav = Array();

			if ($row['like_front'])
				array_push($fav, "Front page");
			if ($row['like_form'])
				array_push($fav, "Form");
			if ($row['like_ui'])
				array_push($fav, "User interface");

			echo "<li>";
			echo "Name : ".$row["user"]."<br>";
			echo "Email : ".$row["email"]."<br>";
			echo "Date : ".$row["postdate"]."<br>";
			echo "Time : ".$row["posttime"]."<br>";
			echo "How did you find me: " . $row['known_from'] . "<br />";
			echo "I like your: ";
			echo join(", ", $fav);
			echo "<br />Comments : ".$row["comment"]."<br>";
			echo "Action : <a href=edit.php?id=".$row["id"].">Edit</a> / <a href=delete.php?id=".$row["id"].">Delete</a>";
			echo "</li>";
			echo "<hr>";
		}
		?>
	</ol>

</body>
</html>