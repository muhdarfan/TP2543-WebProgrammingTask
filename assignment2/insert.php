<?php
if (isset($_POST['add_form'])) {
  include "db.php";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO myguestbook(user, email, postdate, posttime, comment, known_from, like_front, like_form, like_ui) VALUES (:user, :email, :pdate, :ptime, :comment, :known, :like_front, :like_form, :like_ui)");

      // Bind the parameters
    $stmt->bindParam(':user', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':pdate', $postdate, PDO::PARAM_STR);
    $stmt->bindParam(':ptime', $posttime, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

    $stmt->bindParam(':known', $known, PDO::PARAM_STR);
    $stmt->bindParam(':like_front', $like_front, PDO::PARAM_INT);
    $stmt->bindParam(':like_form', $like_form, PDO::PARAM_INT);
    $stmt->bindParam(':like_ui', $like_ui, PDO::PARAM_INT);

      // Give value to the variables
    $name = $_POST['name'];
    $email = $_POST['email'];
    $postdate = date("Y-m-d", time());
    $posttime = date("H:i:s", time());
    $comment = $_POST['comment'];

    $known = $_POST['known'];
    $like_front = (isset($_POST['front_page']) ? 1 : 0);
    $like_form = (isset($_POST['like_form']) ? 1 : 0);
    $like_ui = (isset($_POST['like_ui']) ? 1 : 0);

    $stmt->execute();

    echo "New records created successfully. Click <a href='index.php'>here</a> to go back.";
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