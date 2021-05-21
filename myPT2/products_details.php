<?php
include_once 'database.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Bike Ordering System : Products Details</title>
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
      $stmt = $conn->prepare("SELECT * FROM tbl_products_a174652_pt2 WHERE FLD_PRODUCT_ID = :pid");
      $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
      $pid = $_GET['pid'];
      $stmt->execute();
      $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
      $readrow['FLD_PRODUCT_ID'] = sprintf("MB%03d", $readrow['FLD_PRODUCT_ID']);
    }
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
    Product ID: <?php echo $readrow['FLD_PRODUCT_ID'] ?> <br />
    Name: <?php echo $readrow['FLD_PRODUCT_NAME'] ?> <br />
    Price: RM <?php echo $readrow['FLD_PRICE'] ?> <br />
    Brand: <?php echo $readrow['FLD_BRAND'] ?> <br />
    Socket: <?php echo $readrow['FLD_SOCKET'] ?> <br />
    Manufacturing Year: <?php echo $readrow['FLD_MANUFACTURED_YEAR'] ?> <br />
    Stock: <?php echo $readrow['FLD_STOCK'] ?> <br />
    <img src="products/<?php echo $pid; ?>.png" width="30%" height="30%" style="border: 1px solid #000;border-radius: 10px;padding:10px;" />
  </center>
</body>
</html>