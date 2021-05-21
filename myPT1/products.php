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
    <hr/>

    <form action="products.php" method="post">
      Product ID
      <input name="pid" type="text" /> <br/>

      Name
      <input name="name" type="text" /> <br/>

      Price
      <input name="price" type="text" /> <br/>

      Brand
      <select name="brand">
        <?php
        $brands = array("Asus", "Asrock", "Biostar", "Gigabyte", "MSI", "Maxsun");
        foreach ($brands as $brand) {
          echo "<option value='".strtolower($brand)."'>{$brand}</option>";
        }
        ?>
      </select> <br/>

      Socket
      <select name="socket">
        <?php
        $brands = array("AM3+", "AM4", "LGA1151", "LGA2066");
        foreach ($brands as $brand) {
          echo "<option value='".strtolower($brand)."'>{$brand}</option>";
        }
        ?>
      </select> <br/>

      Manufacturing Year
      <select name="year">
        <?php
        $years = range(date("Y"), 1990);
        foreach ($years as $year) {
          echo "<option value='{$year}'>{$year}</option>";
        }
        ?>
      </select> <br/>

      Stock
      <input name="stock" type="number" min="1"> <br/>
      <button type="submit" name="create">Create</button>
      <button type="reset">Clear</button>
    </form>
    <hr>
    <table border="1">
      <tr>
        <td>Product ID</td>
        <td>Name</td>
        <td>Price</td>
        <td>Brand</td>
        <td>Socket</td>
        <td>Mfg Year</td>
        <td>Stock</td>
        <td></td>
      </tr>
      <tr>
        <td>MB001</td>
        <td>Asrock A320M-DGS</td>
        <td>698</td>
        <td>Asrock</td>
        <td>AM4</td>
        <td>2017</td>
        <td>12</td>
        <td>
          <a href="products_details.php">Details</a>
          <a href="products.php">Edit</a>
          <a href="products.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>MB002</td>
        <td>Asrock A320M-HDV R4.0</td>
        <td>667</td>
        <td>Asrock</td>
        <td>AM4</td>
        <td>2019</td>
        <td>9</td>
        <td>
          <a href="#">Details</a>
          <a href="products.php">Edit</a>
          <a href="products.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>MB003</td>
        <td>Gigabyte GA-H170-Gaming 3 Rev. 1.1</td>
        <td>913</td>
        <td>Gigabyte</td>
        <td>LGA</td>
        <td>2015</td>
        <td>9</td>
        <td>
          <a href="#">Details</a>
          <a href="products.php">Edit</a>
          <a href="products.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>MB004</td>
        <td>MSI B250M Pro-VDH</td>
        <td>916</td>
        <td>MSI</td>
        <td>LGA</td>
        <td>2017</td>
        <td>14</td>
        <td>
          <a href="#">Details</a>
          <a href="products.php">Edit</a>
          <a href="products.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>MB005</td>
        <td>Biostar TB250-BTC Pro</td>
        <td>731</td>
        <td>Biostar</td>
        <td>AM4</td>
        <td>2017</td>
        <td>9</td>
        <td>
          <a href="#">Details</a>
          <a href="products.php">Edit</a>
          <a href="products.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>MB006</td>
        <td>Asus ROG Strix Z270E Gaming</td>
        <td>919</td>
        <td>Asus</td>
        <td>LGA</td>
        <td>2017</td>
        <td>2</td>
        <td>
          <a href="#">Details</a>
          <a href="products.php">Edit</a>
          <a href="products.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>MB007</td>
        <td>Asus ROG Strix B350-F Gaming</td>
        <td>879</td>
        <td>Asus</td>
        <td>AM4</td>
        <td>2017</td>
        <td>17</td>
        <td>
          <a href="#">Details</a>
          <a href="products.php">Edit</a>
          <a href="products.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>MB008</td>
        <td>Asrock A320M-DGS</td>
        <td>698</td>
        <td>Asrock</td>
        <td>AM4</td>
        <td>2017</td>
        <td>12</td>
        <td>
          <a href="#">Details</a>
          <a href="products.php">Edit</a>
          <a href="products.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>MB009</td>
        <td>Asrock Fatal1ty 990FX Killer</td>
        <td>447</td>
        <td>Asrock</td>
        <td>AM3+</td>
        <td>2013</td>
        <td>18</td>
        <td>
          <a href="#">Details</a>
          <a href="products.php">Edit</a>
          <a href="products.php">Delete</a>
        </td>
      </tr>
      <tr>
        <td>MB010</td>
        <td>Asrock H110M-HDS</td>
        <td>617</td>
        <td>Asrock</td>
        <td>LGA</td>
        <td>2015</td>
        <td>6</td>
        <td>
          <a href="#">Details</a>
          <a href="products.php">Edit</a>
          <a href="products.php">Delete</a>
        </td>
      </tr>
    </table>
  </center>
</body>
</html>