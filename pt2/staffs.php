<?php
  include_once 'staffs_crud.php';
?>
 
<!DOCTYPE html>
<html>
<head>
  <title>My Bike Ordering System : Staffs</title>
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
      Customer ID
      <input name="sid" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_num']; ?>"> <br>
      First Name
      <input name="fname" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_fname']; ?>"> <br>
      Last Name
      <input name="lname" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_lname']; ?>"> <br>
      Gender
      <input name="gender" type="radio" value="Male" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_gender']=="Male") echo "checked"; ?>> Male
      <input name="gender" type="radio" value="Female" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_gender']=="Female") echo "checked"; ?>> Female <br>
      Phone Number
      <input name="phone" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_phone']; ?>"> <br>
      Email Address
      <input name="email" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_email']; ?>"> <br>
      <?php if (isset($_GET['edit'])) { ?>
      <input type="hidden" name="oldsid" value="<?php echo $editrow['fld_staff_num']; ?>">
      <button type="submit" name="update">Update</button>
      <?php } else { ?>
      <button type="submit" name="create">Create</button>
      <?php } ?>
      <button type="reset">Clear</button>
    </form>
    <hr>
    <table border="1">
      <tr>
        <td>Staff ID</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Gender</td>
        <td>Phone Number</td>
        <td>Email Address</td>
        <td></td>
      </tr>
      <?php
      // Read
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a174652");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?>
      <tr>
        <td><?php echo $readrow['fld_staff_num']; ?></td>
        <td><?php echo $readrow['fld_staff_fname']; ?></td>
        <td><?php echo $readrow['fld_staff_lname']; ?></td>
        <td><?php echo $readrow['fld_staff_gender']; ?></td>
        <td><?php echo $readrow['fld_staff_phone']; ?></td>
        <td><?php echo $readrow['fld_staff_email']; ?></td>
        <td>
          <a href="staffs.php?edit=<?php echo $readrow['fld_staff_num']; ?>">Edit</a>
          <a href="staffs.php?delete=<?php echo $readrow['fld_staff_num']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
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