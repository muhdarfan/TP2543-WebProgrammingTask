<?php
include_once 'customers_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Motherboard Ordering System : Customers</title>
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
      <?php
      if (isset($_GET['edit'])) {
        echo '<input type="hidden" name="cid" value="'.$editrow['FLD_CUSTOMER_ID'].'" />';
      }
      ?>
      Customer ID
      <input type="text" value="<?php echo (isset($_GET['edit']) ? $fid : $NextID); ?>" readonly="true"> <br />
      Full Name
      <input name="name" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_NAME']; ?>"> <br />
      Address
      <textarea rows="5" name="address"><?php if (isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_ADDRESS']; ?></textarea><br />
      Phone Number
      <input name="phone" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_PHONE']; ?>"> <br />
      <?php if (isset($_GET['edit'])) { ?>
        <input type="hidden" name="oldcid" value="<?php echo $editrow['FLD_CUSTOMER_ID']; ?>">
        <button type="submit" name="update">Update</button>
      <?php } else { ?>
        <button type="submit" name="create">Create</button>
      <?php } ?>
      <button type="reset">Clear</button>
    </form>
    <hr>
    <table border="1">
      <tr>
        <td>Customer ID</td>
        <td>Full Name</td>
        <td>Address</td>
        <td>Phone Number</td>
        <td>Action</td>
      </tr>
      <?php
      // Read
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_customers_a174652_pt2");
        $stmt->execute();
        $result = $stmt->fetchAll();
      } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
        ?>
        <tr>
          <td><?php echo sprintf("C%03d",$readrow['FLD_CUSTOMER_ID']); ?></td>
          <td><?php echo $readrow['FLD_CUSTOMER_NAME']; ?></td>
          <td><?php echo $readrow['FLD_CUSTOMER_ADDRESS']; ?></td>
          <td><?php echo $readrow['FLD_CUSTOMER_PHONE']; ?></td>
          <td>
            <a href="customers.php?edit=<?php echo $readrow['FLD_CUSTOMER_ID']; ?>">Edit</a>
            <a href="customers.php?delete=<?php echo $readrow['FLD_CUSTOMER_ID']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
          </td>
        </tr>
        <?php
      }
      $conn = null;
      ?>
    </table>
  </center>
</body>
</html>