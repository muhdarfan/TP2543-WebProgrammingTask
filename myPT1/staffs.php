<!DOCTYPE html>
<html>
<head>
  <title>My Motherboard Ordering System : Staffs</title>
</head>
<body>
  <center>
    <a href="index.php">Home</a> |
    <a href="products.php">Products</a> |
    <a href="customers.php">Customers</a> |
    <a href="staffs.php">Staffs</a> |
    <a href="orders.php">Orders</a>
    <hr>
    <form action="staffs.php" method="post">
      Staff ID
      <input name="sid" type="text"> <br>
      Full Name
      <input name="fname" type="text"> <br>
      Phone Number
      <input name="phone" type="text"> <br>
      <button type="submit" name="create">Create</button>
      <button type="reset">Clear</button>
    </form>
    <hr>
    <table border="1">
      <tr>
        <td>Staff ID</td>
        <td>Full Name</td>
        <td>Phone Number</td>
        <td></td>
      </tr>
      <tr>
        <td>S001</td>
        <td>Larry Bare</td>
        <td>013-3922010</td>
        <td>
          <a href="staffs.php">Edit</a>
          <a href="staffs.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>S002</td>
        <td>James Martin</td>
        <td>019-8321266</td>
        <td>
          <a href="staffs.php">Edit</a>
          <a href="staffs.php">Delete</a>
        </td>
      </tr>
    </table>
  </center>
</body>
</html>