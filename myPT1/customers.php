<!DOCTYPE html>
<html>
<head>
  <title>My Bike Ordering System : Customers</title>
</head>
<body>
  <center>
    <a href="index.php">Home</a> |
    <a href="products.php">Products</a> |
    <a href="customers.php">Customers</a> |
    <a href="staffs.php">Staffs</a> |
    <a href="orders.php">Orders</a>
    <hr>
    <form action="customers.php" method="post">
      Customer ID
      <input name="cid" type="text" /> <br />
      Full Name
      <input name="fname" type="text" /> <br />
      Address
      <textarea name="address" rows="4"></textarea> <br />
      Phone Number
      <input name="phone" type="text" /> <br />

      <button type="submit" name="create">Create</button>
      <button type="reset">Clear</button>
    </form>
    <hr>
    <table border="1">
      <tr>
        <td>Customer ID</td>
        <td>Full Name</td>
        <td>Address</td>
        <td>Phone Number</td>
        <td></td>
      </tr>
      <tr>
        <td>C001</td>
        <td>Maria</td>
        <td>Singapore</td>
        <td>019-2849132</td>
        <td>
          <a href="customers.php">Edit</a>
          <a href="customers.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>C002</td>
        <td>Antonio</td>
        <td>Malaysia</td>
        <td>011-7226581</td>
        <td>
          <a href="customers.php">Edit</a>
          <a href="customers.php">Delete</a>
        </td>
      </tr>
    </table>
  </center>
</body>
</html>