<?php
if (isset($_POST['biodata_validate'])) {
	// Connection variables
	$servername = "lrgs.ftsm.ukm.my";
	$username = "a174652";
	$password = "tinygreenspider";
	$dbname = "a174652";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Prepare the SQL statement
		$stmt = $conn->prepare("INSERT INTO biodata(name, age, sex, address, email, dob, height, phone, color, fbtwig, univ) VALUES (:name, :age, :sex, :address, :email, :dob, :height, :phone, :color, :fbtwig, :univ)");

		$name = $_POST['name'];
		$age = $_POST['age'];
		$sex = $_POST['sex'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$dob = $_POST['dob'];
		$height = $_POST['height'];
		$phone = $_POST['phone'];
		$color = $_POST['color'];
		$fbtwig = $_POST['fbtwig'];
		$univ = $_POST['univ'];

		// Bind the parameters
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':age', $age, PDO::PARAM_INT);
		$stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
		$stmt->bindParam(':address', $address, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
		$stmt->bindParam(':height', $height, PDO::PARAM_INT);
		$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
		$stmt->bindParam(':color', $color, PDO::PARAM_STR);
		$stmt->bindParam(':fbtwig', $fbtwig, PDO::PARAM_STR);
		$stmt->bindParam(':univ', $univ, PDO::PARAM_STR);

		// insert a row
		$stmt->execute();
		echo "New records created successfully";
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
}
?>