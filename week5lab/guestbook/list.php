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
  echo "<li>";
  echo "Name : ".$row["user"]."<br>";
  echo "Email : ".$row["email"]."<br>";
  echo "Date : ".$row["postdate"]."<br>";
  echo "Time : ".$row["posttime"]."<br>";
  echo "Comments : ".$row["comment"]."<br>";
  echo "Action : <a href=edit.php?id=".$row["id"].">Edit</a> / <a href=delete.php?id=".$row["id"].">Delete</a>";
  echo "</li>";
  echo "<hr>";
}
?>
</ol>
 
</body>
</html>