<?php
  include_once 'customers_crud.php';
?>
 
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
      <input name="cid" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_num']; ?>"> <br>
      First Name
      <input name="fname" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_fname']; ?>"> <br>
      Last Name
      <input name="lname" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_lname']; ?>"> <br>
      Gender
      <input name="gender" type="radio" value="Male" <?php if(isset($_GET['edit'])) if($editrow['fld_customer_gender']=="Male") echo "checked"; ?>> Male
      <input name="gender" type="radio" value="Female" <?php if(isset($_GET['edit'])) if($editrow['fld_customer_gender']=="Female") echo "checked"; ?>> Female <br>
      Phone Number
      <input name="phone" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_phone']; ?>"> <br>
      <?php if (isset($_GET['edit'])) { ?>
      <input type="hidden" name="oldcid" value="<?php echo $editrow['fld_customer_num']; ?>">
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
        <td>First Name</td>
        <td>Last Name</td>
        <td>Gender</td>
        <td>Phone Number</td>
        <td></td>
      </tr>
      <?php
      // Read
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_customers_a174652");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?>
      <tr>
        <td><?php echo $readrow['fld_customer_num']; ?></td>
        <td><?php echo $readrow['fld_customer_fname']; ?></td>
        <td><?php echo $readrow['fld_customer_lname']; ?></td>
        <td><?php echo $readrow['fld_customer_gender']; ?></td>
        <td><?php echo $readrow['fld_customer_phone']; ?></td>
        <td>
          <a href="customers.php?edit=<?php echo $readrow['fld_customer_num']; ?>">Edit</a>
          <a href="customers.php?delete=<?php echo $readrow['fld_customer_num']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
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