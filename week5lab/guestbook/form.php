<!DOCTYPE html>
<html>
<head>
  <title>My Guestbook</title>
</head>

<body>
 
  <form method="post" action="insert.php">
    Nama :
    <input type="text" name="name" size="40" required>
    <br>
    Email :
    <input type="text" name="email" size="25" required>
    <br>
    Comments :<br>
    <textarea name="comment" cols="30" rows="8" required></textarea>
    <br>
    <input type="submit" name="add_form" value="Add a New Comment">
    <input type="reset">
    <br>
  </form>
  
</body>
</html>