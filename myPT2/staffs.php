<?php
  include_once 'staffs_crud.php';
?>
 
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
      <?php
      if (isset($_GET['edit'])) {
        echo '<input type="hidden" name="sid" value="'.$editrow['FLD_STAFF_ID'].'" />';
      }
      ?>
      Staff ID
      <input type="text" value="<?php echo (isset($_GET['edit']) ? $fid : $NextID); ?>"> <br />
      Full Name
      <input name="name" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_STAFF_NAME']; ?>"> <br />
      Gender
      <input name="gender" type="radio" value="male" <?php if(isset($_GET['edit'])) if($editrow['FLD_STAFF_GENDER']=="male") echo "checked"; ?>> Male
      <input name="gender" type="radio" value="female" <?php if(isset($_GET['edit'])) if($editrow['FLD_STAFF_GENDER']=="female") echo "checked"; ?>> Female <br />
      Phone Number
      <input name="phone" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_STAFF_PHONE']; ?>"> <br />
      <?php if (isset($_GET['edit'])) { ?>
      <input type="hidden" name="oldsid" value="<?php echo $editrow['FLD_STAFF_ID']; ?>">
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
        <td>Full Name</td>
        <td>Gender</td>
        <td>Phone Number</td>
        <td></td>
      </tr>
      <?php
      // Read
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a174652_pt2");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?>
      <tr>
        <td><?php echo sprintf("S%03d", $readrow['FLD_STAFF_ID']); ?></td>
        <td><?php echo $readrow['FLD_STAFF_NAME']; ?></td>
        <td><?php echo ucfirst($readrow['FLD_STAFF_GENDER']); ?></td>
        <td><?php echo $readrow['FLD_STAFF_PHONE']; ?></td>
        <td>
          <a href="staffs.php?edit=<?php echo $readrow['FLD_STAFF_ID']; ?>">Edit</a>
          <a href="staffs.php?delete=<?php echo $readrow['FLD_STAFF_ID']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
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