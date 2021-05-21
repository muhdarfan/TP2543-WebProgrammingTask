<?php
include_once 'products_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Motherboard Ordering System : Products</title>
</head>
<body>
  <center>
    <a href="index.php">Home</a> |
    <a href="products.php">Products</a> |
    <a href="customers.php">Customers</a> |
    <a href="staffs.php">Staffs</a> |
    <a href="orders.php">Orders</a>
    <hr />
    <?php
    if(isset($editrow) && count($editrow) > 0) {
      echo "<h2>Editing #".$fID."</h2>";
    }
    ?>

    <form action="products.php" method="post">
      <?php
      if (isset($_GET['edit']))
        echo "<input type='hidden' name='pid' value='".$editrow['FLD_PRODUCT_ID']."' />";
      ?>
      Product ID
      <input type="text" value="<?php if(isset($_GET['edit'])) echo $fID; else echo $NextID; ?>" disabled readonly="true"> <br />
      Name
      <input name="name" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_NAME']; ?>"> <br />
      Price
      <input name="price" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRICE']; ?>"> <br />
      Brand
      <select name="brand">
        <option value="Asrock" <?php if(isset($_GET['edit'])) if($editrow['FLD_BRAND']=="Asrock") echo "selected"; ?>>Asrock</option>
        <option value="Asus" <?php if(isset($_GET['edit'])) if($editrow['FLD_BRAND']=="Asus") echo "selected"; ?>>Asus</option>
        <option value="Biostar" <?php if(isset($_GET['edit'])) if($editrow['FLD_BRAND']=="Biostar") echo "selected"; ?>>Biostar</option>
        <option value="Gigabyte" <?php if(isset($_GET['edit'])) if($editrow['FLD_BRAND']=="Gigabyte") echo "selected"; ?>>Gigabyte</option>
        <option value="MSI" <?php if(isset($_GET['edit'])) if($editrow['FLD_BRAND']=="MSI") echo "selected"; ?>>MSI</option>
        <option value="Maxsun" <?php if(isset($_GET['edit'])) if($editrow['FLD_BRAND']=="Maxsun") echo "selected"; ?>>Maxsun</option>
      </select> <br />
      Socket
      <input name="socket" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_SOCKET']; ?>"> <br>
      Manufacturing Year
      <select name="year">
        <?php
        foreach(range(date('Y'), 2000) as $year) {
          echo "<option value='{$year}' ".($year == $editrow['FLD_MANUFACTURED_YEAR'] ? 'selected' : '' ).">{$year}</option>";
        }
        ?>
      </select> <br />
      Stock
      <input name="stock" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_STOCK']; ?>"> <br /><br />

      <?php if (isset($_GET['edit'])) { ?>
        <input type="hidden" name="oldpid" value="<?php echo $editrow['FLD_PRODUCT_ID']; ?>">
        <button type="submit" name="update">Update</button>
      <?php } else { ?>
        <button type="submit" name="create">Create</button>
      <?php } ?>
      <button type="reset">Clear</button>
    </form>

    <hr />
    <h2>Product List</h2>
    <section>
      <table border="1">
        <tr>
          <td>Product ID</td>
          <td>Name</td>
          <td>Price</td>
          <td>Brand</td>
          <td>Socket</td>
          <td>Mfg. Year</td>
          <td>Stock</td>
          <td>Action</td>
        </tr>
        <?php
      // Read
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
        foreach($result as $readrow) {
          ?>   
          <tr>
            <td><?php echo sprintf("MB%03d", $readrow['FLD_PRODUCT_ID']); ?></td>
            <td><?php echo $readrow['FLD_PRODUCT_NAME']; ?></td>
            <td><?php echo $readrow['FLD_PRICE']; ?></td>
            <td><?php echo $readrow['FLD_BRAND']; ?></td>
            <td><?php echo $readrow['FLD_SOCKET']; ?></td>
            <td><?php echo $readrow['FLD_MANUFACTURED_YEAR']; ?></td>
            <td><?php echo $readrow['FLD_STOCK']; ?></td>
            <td>
              <a href="products_details.php?pid=<?php echo $readrow['FLD_PRODUCT_ID']; ?>">Details</a>
              <a href="products.php?edit=<?php echo $readrow['FLD_PRODUCT_ID']; ?>">Edit</a>
              <a href="products.php?delete=<?php echo $readrow['FLD_PRODUCT_ID']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
            </td>
          </tr>
          <?php
        }
        $conn = null;
        ?>
      </table>
    </section>
  </center>
</body>
</html>