<!DOCTYPE html>
<html>
<head>
  <title>My Bike Ordering System : Order Details</title>
</head>
<body>
  <center>
    <a href="index.php">Home</a> |
    <a href="products.php">Products</a> |
    <a href="customers.php">Customers</a> |
    <a href="staffs.php">Staffs</a> |
    <a href="orders.php">Orders</a>
    <hr>
    Order ID: O5603f03a9349f0.39900158<br>
    Order Date: 09-09-2015 <br>
    Staff: James Martin <br>
    Customer: Maria Garcia <br>
    <hr>
    <form action="orders_details.php" method="post">
      Product
      <select name="pid">
        <option value="P001">Ninja Zx-14r Abs</option>
        <option value="P002">Ninja Zx-10r Abs 30th Anniversary</option>
        <option value="P003">Ninja Zx-10r Abs</option>
      </select>
      Quantity
      <input name="quantity" type="text">
      <button type="submit" name="addproduct">Add Product</button>
      <button type="reset">Clear</button>
    </form>
    <hr>
    <table border="1">
      <tr>
        <td>Order Detail ID</td>
        <td>Product</td>
        <td>Quantity</td>
        <td></td>
      </tr>
      <tr>
        <td>D5603f136f41334.84833440</td>
        <td>Concours 14 Abs</td>
        <td>1</td>
        <td>
          <a href="orders_details.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>O5603f03a9349f0.39900158</td>
        <td>Versys 650 Lt</td>
        <td>2</td>
        <td>
          <a href="orders_details.php">Delete</a>
        </td>
      </tr>
    </table>
    <hr>
    <a href="invoice.php" target="_blank">Generate Invoice</a>
  </center>
</body>
</html>