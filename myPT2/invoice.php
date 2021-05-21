<?php
  include_once 'database.php';
?>
 
<!DOCTYPE html>
<html>
<head>
  <title>My Motherboard Ordering System : Invoice</title>
</head>
<body>
  <center>
    <strong>EagleZ Computer Shop Enterprise</strong> <br />
    B12-1, Blok B, <br />
    Jalan Dato Seri Ahmad Said,<br />
    30450 Ipoh,<br />
    Perak.<br />
    <hr/>

    <?php
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT * FROM tbl_orders_a174652, tbl_staffs_a174652_pt2,
        tbl_customers_a174652_pt2, tbl_orders_details_a174652 WHERE
        tbl_orders_a174652.fld_staff_num = tbl_staffs_a174652_pt2.FLD_STAFF_ID AND
        tbl_orders_a174652.fld_customer_num = tbl_customers_a174652_pt2.FLD_CUSTOMER_ID AND
        tbl_orders_a174652.fld_order_num = tbl_orders_details_a174652.fld_order_num AND
        tbl_orders_a174652.fld_order_num = :oid");
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
    Order ID: <?php echo $readrow['fld_order_num'] ?> |
    Order Date: <?php echo $readrow['fld_order_date'] ?>
    <hr>
    Staff: <?php echo $readrow['FLD_STAFF_NAME']; ?> | 
    Customer ID: <?php echo $readrow['FLD_CUSTOMER_NAME']; ?> |
    Date: <?php echo date("d M Y"); ?>
    <hr>
    <table border="1">
      <tr>
        <td>No</td>
        <td>Product</td>
        <td>Quantity</td>
        <td>Price(RM)/Unit</td>
        <td>Total(RM)</td>
      </tr>
      <?php
      $grandtotal = 0;
      $counter = 1;
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_orders_details_a174652,
            tbl_products_a174652_pt2 where 
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
        <td><?php echo $counter; ?></td>
        <td><?php echo $detailrow['FLD_PRODUCT_NAME']; ?></td>
        <td><?php echo $detailrow['fld_order_detail_quantity']; ?></td>
        <td><?php echo number_format($detailrow['FLD_PRICE'], 2); ?></td>
        <td><?php echo number_format($detailrow['FLD_PRICE']*$detailrow['fld_order_detail_quantity'], 2); ?></td>
      </tr>
      <?php
        $grandtotal = $grandtotal + $detailrow['FLD_PRICE']*$detailrow['fld_order_detail_quantity'];
        $counter++;
      } // while
      $conn = null;
      ?>
      <tr>
        <td colspan="4" align="right">Grand Total</td>
        <td><?php echo number_format($grandtotal, 2) ?></td>
      </tr>
    </table>
    <hr>
    Computer-generated invoice. No signature is required.
 
  </center>
</body>
</html>