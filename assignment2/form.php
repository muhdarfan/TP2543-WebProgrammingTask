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
        <form method="post" action="insert.php">
            Name :
            <input type="text" name="name" size="40" required>
            <br>
            Email :
            <input type="text" name="email" size="25" required>
            <br>
            Comments :<br>
            <textarea name="comment" cols="30" rows="8" required></textarea>
            <br/>
            How did you find me?
            <select name="known">
                <option>From a friend</option>
                <option>I googled you</option>
                <option>Just surf on in</option>
                <option>From your Facebook</option>
                <option>I clicked an ads</option>
            </select> <br />
            I like your: <br />
            <input type="checkbox" id="front_page" name="front_page" value="fp">
            <label for="front_page">Front Page</label>

            <input type="checkbox" id="form" name="like_form" value="form">
            <label for="form">Form</label>

            <input type="checkbox" id="ui" name="like_ui" value="ui">
            <label for="ui">User Interface</label>

            <input type="submit" name="add_form" value="Add a New Comment">
            <input type="reset">
            <br>
        </form>
    </div>
</body>
</html>