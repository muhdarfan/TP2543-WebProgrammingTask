<?php
include_once 'products_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Bike Ordering System : Products</title>
</head>
<body>
  <center>
    <a href="index.php">Home</a> |
    <a href="products.php">Products</a> |
    <a href="customers.php">Customers</a> |
    <a href="staffs.php">Staffs</a> |
    <a href="orders.php">Orders</a>
    <hr>
    <form action="products.php" method="post">
      Product ID
      <input name="pid" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_num']; ?>"> <br>
      Name
      <input name="name" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_name']; ?>"> <br>
      Price
      <input name="price" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_price']; ?>"> <br>
      Brand
      <select name="brand">
        <option value="Kawasaki" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="Kawasaki") echo "selected"; ?>>Kawasaki</option>
        <option value="Honda" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="Honda") echo "selected"; ?>>Honda</option>
        <option value="Suzuki" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="Suzuki") echo "selected"; ?>>Suzuki</option>
      </select> <br>
      Condition
      <input name="cond" type="radio" value="New" <?php if(isset($_GET['edit'])) if($editrow['fld_product_condition']=="New") echo "checked"; ?>> New
      <input name="cond" type="radio" value="Used" <?php if(isset($_GET['edit'])) if($editrow['fld_product_condition']=="Used") echo "checked"; ?>> Used <br>
      Manufacturing Year
      <select name="year">
        <option value="2013" <?php if(isset($_GET['edit'])) if($editrow['fld_product_year']=="2013") echo "selected"; ?>>2013</option>
        <option value="2014" <?php if(isset($_GET['edit'])) if($editrow['fld_product_year']=="2014") echo "selected"; ?>>2014</option>
        <option value="2015" <?php if(isset($_GET['edit'])) if($editrow['fld_product_year']=="2015") echo "selected"; ?>>2015</option>
      </select> <br>
      Quantity
      <input name="quantity" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_quantity']; ?>"> <br>
      <?php if (isset($_GET['edit'])) { ?>
        <input type="hidden" name="oldpid" value="<?php echo $editrow['fld_product_num']; ?>">
        <button type="submit" name="update">Update</button>
      <?php } else { ?>
        <button type="submit" name="create">Create</button>
      <?php } ?>
      <button type="reset">Clear</button>
    </form>
    <hr>
    <table border="1">
      <tr>
        <td>Product ID</td>
        <td>Name</td>
        <td>Price</td>
        <td>Brand</td>
        <td></td>
      </tr>
      <?php
      // Read
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_products_a174652");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
        echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
        ?>   
        <tr>
          <td><?php echo $readrow['fld_product_num']; ?></td>
          <td><?php echo $readrow['fld_product_name']; ?></td>
          <td><?php echo $readrow['fld_product_price']; ?></td>
          <td><?php echo $readrow['fld_product_brand']; ?></td>
          <td>
            <a href="products_details.php?pid=<?php echo $readrow['fld_product_num']; ?>">Details</a>
            <a href="products.php?edit=<?php echo $readrow['fld_product_num']; ?>">Edit</a>
            <a href="products.php?delete=<?php echo $readrow['fld_product_num']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
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