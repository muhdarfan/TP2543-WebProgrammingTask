<?php
 
if (isset($_POST['edit_form'])) {
 
  include "db.php";
 
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
    $stmt = $conn->prepare("UPDATE myguestbook SET user = :name, email = :email, comment = :comment, known_from = :known, like_front = :like_front, like_form = :like_form, like_ui = :like_ui WHERE id = :record_id");
 
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':record_id', $id, PDO::PARAM_INT);

    $stmt->bindParam(':known', $known, PDO::PARAM_STR);
    $stmt->bindParam(':like_front', $like_front, PDO::PARAM_INT);
    $stmt->bindParam(':like_form', $like_form, PDO::PARAM_INT);
    $stmt->bindParam(':like_ui', $like_ui, PDO::PARAM_INT);
       
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $id = $_POST['id'];

    $known = $_POST['known'];
    $like_front = (isset($_POST['front_page']) ? 1 : 0);
    $like_form = (isset($_POST['like_form']) ? 1 : 0);
    $like_ui = (isset($_POST['like_ui']) ? 1 : 0);
 
    $stmt->execute();
     
    header("Location:list.php");
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