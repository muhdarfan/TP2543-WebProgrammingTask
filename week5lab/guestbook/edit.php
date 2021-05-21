<?php

if (isset($_GET['id'])) {
 
  include "db.php";
  
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("SELECT * FROM myguestbook WHERE id = :record_id");
    $stmt->bindParam(':record_id', $id, PDO::PARAM_INT);
    $id = $_GET['id'];
    
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
  }
  
  catch(PDOException $e)
  {
    echo "Error: " . $e->getMessage();
  }
  
  $conn = null;
}
else {
  echo "Error: You have execute a wrong PHP. Please contact the web administrator.";
  die();
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>My Guestbook</title>
</head>

<body>
 
  <form method="post" action="update.php">
    Nama :
    <input type="text" name="name" size="40" required value="<?php echo $result["user"]; ?>">
    <br>
    Email :
    <input type="text" name="email" size="25" required value="<?php echo $result["email"]; ?>">
    <br>
    Comments :<br>
    <textarea name="comment" cols="30" rows="8" required><?php echo $result["comment"]; ?></textarea>
    <br>
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <input type="submit" name="edit_form" value="Modify Comment">
    <input type="reset">
    <br>
  </form>
  
</body>
</html>