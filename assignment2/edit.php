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

  <style type="text/css">
    input[type=text], select, textarea {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      resize: none;
    }

    input[type=submit], input[type=reset] {
      width: 100%;
      background-color: #4CAF50;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type=submit]:hover, , input[type=reset]:hover {
      background-color: #45a049;
    }

    div {
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 20px;
      width: 50%;
      margin: 0 auto;
    }
  </style>
</head>

<body>
  <div>
    <form method="post" action="update.php">
      Nama :
      <input type="text" name="name" size="40" required value="<?php echo $result["user"]; ?>">
      <br>
      Email :
      <input type="text" name="email" size="25" required value="<?php echo $result["email"]; ?>">
      <br>
      How did you find me?
      <select name="known">
        <option>From a friend</option>
        <option>I googled you</option>
        <option>Just surf on in</option>
        <option>From your Facebook</option>
        <option>I clicked an ads</option>
      </select> <br />
      I like your: <br />
      <input type="checkbox" id="front_page" name="front_page" value="fp" <?php if ($result['like_front'] == 1) echo "checked"; ?>>
      <label for="front_page">Front Page</label>

      <input type="checkbox" id="form" name="like_form" value="form" <?php if ($result['like_form'] == 1) echo "checked"; ?>>
      <label for="form">Form</label>
      <input type="checkbox" id="ui" name="like_ui" value="ui" <?php if ($result['like_ui'] == 1) echo "checked"; ?>>

      <label for="ui">User Interface</label>
      <br />
      Comments :<br>
      <textarea name="comment" cols="30" rows="8" required><?php echo $result["comment"]; ?></textarea>
      <br>
      <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
      <input type="submit" name="edit_form" value="Modify Comment">
      <input type="reset">
      <br>
    </form>
  </div>
</body>
</html>