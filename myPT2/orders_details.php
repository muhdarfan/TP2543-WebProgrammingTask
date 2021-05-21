<?php
include_once 'orders_details_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Motherboard Ordering System : Order Details</title>
</head>
<body>
  <center>
    <a href="index.php">Home</a> |
    <a href="products.php">Products</a> |
    <a href="customers.php">Customers</a> |
    <a href="staffs.php">Staffs</a> |
    <a href="orders.php">Orders</a>
    <hr>
    <?php
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT * FROM tbl_orders_a174652, tbl_staffs_a174652_pt2,
        tbl_customers_a174652_pt2 WHERE
        tbl_orders_a174652.fld_staff_num = tbl_staffs_a174652_pt2.FLD_STAFF_ID AND
        tbl_orders_a174652.fld_customer_num = tbl_customers_a174652_pt2.FLD_CUSTOMER_ID AND
        fld_order_num = :oid");
      $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
      $oid = $_GET['oid'];
      $stmt->execute();
      $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
    Order ID: <?php echo $readrow['fld_order_num']; ?> <br>
    Order Date: <?php echo $readrow['fld_order_date']; ?> <br>
    Staff: <?php echo $readrow['FLD_STAFF_NAME']; ?> <br>
    Customer: <?php echo $readrow['FLD_CUSTOMER_NAME']; ?> <br>
    <hr>
    <form action="orders_details.php" method="post">
      Product
      <select name="pid">
        <?php
        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_products_a174652_pt2");
          $stmt->execute();
          $result = $stmt->fetchAll();
        }
        catch(PDOException $e){
          echo "Error: " . $e->getMessage();
        }
        foreach($result as $productrow) {
          ?>
          <option value="<?php echo $productrow['FLD_PRODUCT_ID']; ?>"><?php echo $productrow['FLD_BRAND']." ".$productrow['FLD_PRODUCT_NAME']; ?></option>
          <?php
        }
        $conn = null;
        ?>
      </select>
      Quantity
      <input name="quantity" type="number" min="1">
      <input name="oid" type="hidden" value="<?php echo $readrow['fld_order_num']; ?>">
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
      <?php
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_orders_details_a174652,
          tbl_products_a174652_pt2 WHERE
          tbl_orders_details_a174652.fld_product_num = tbl_products_a174652_pt2.FLD_PRODUCT_ID AND
          fld_order_num = :oid");
        $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
        $oid = $_GET['oid'];
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
        echo "Error: " . $e->getMessage();
      }
      foreach($result as $detailrow) {
        ?>
        <tr>
          <td><?php echo $detailrow['fld_order_detail_num']; ?></td>
          <td><?php echo $detailrow['FLD_PRODUCT_NAME']; ?></td>
          <td><?php echo $detailrow['fld_order_detail_quantity']; ?></td>
          <td>
            <a href="orders_details.php?delete=<?php echo $detailrow['fld_order_detail_num']; ?>&oid=<?php echo $_GET['oid']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
          </td>
        </tr>
        <?php
      }
      $conn = null;
      ?>
    </table>
    <hr>
    <a href="invoice.php?oid=<?php echo $_GET['oid']; ?>" target="_blank">Generate Invoice</a>

  </center>
</body>
</html>