<?php

include_once 'database.php';

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Create
if (isset($_POST['create'])) {

  try {

    $stmt = $conn->prepare("INSERT INTO tbl_customers_a174652_pt2(FLD_CUSTOMER_NAME, FLD_CUSTOMER_ADDRESS, FLD_CUSTOMER_PHONE) VALUES(:name,
      :address, :phone)");

    //$stmt->bindParam(':cid', $cid, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

    //$cid = $_POST['cid'];
    $name = $_POST['name'];
    $address =  $_POST['address'];
    $phone = $_POST['phone'];

    $stmt->execute();
  }

  catch(PDOException $e)
  {
    echo "Error: " . $e->getMessage();
  }
}

//Update
if (isset($_POST['update'])) {

  try {

    $stmt = $conn->prepare("UPDATE tbl_customers_a174652_pt2 SET FLD_CUSTOMER_ID = :cid,
      FLD_CUSTOMER_NAME = :name,
      FLD_CUSTOMER_ADDRESS = :address, FLD_CUSTOMER_PHONE = :phone
      WHERE FLD_CUSTOMER_ID = :oldcid");

    $stmt->bindParam(':cid', $cid, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':oldcid', $oldcid, PDO::PARMA_INT);

    $cid = $_POST['cid'];
    $name = $_POST['name'];
    $address =  $_POST['address'];
    $phone = $_POST['phone'];
    $oldcid = $_POST['oldcid'];

    $stmt->execute();

    header("Location: customers.php");
  }

  catch(PDOException $e)
  {
    echo "Error: " . $e->getMessage();
  }
}

//Delete
if (isset($_GET['delete'])) {

  try {

    $stmt = $conn->prepare("DELETE FROM tbl_customers_a174652_pt2 WHERE FLD_CUSTOMER_ID = :cid");

    $stmt->bindParam(':cid', $cid, PDO::PARAM_INT);

    $cid = $_GET['delete'];

    $stmt->execute();

    header("Location: customers.php");
  }

  catch(PDOException $e)
  {
    echo "Error: " . $e->getMessage();
  }
}

//Edit
if (isset($_GET['edit'])) {

  try {

    $stmt = $conn->prepare("SELECT * FROM tbl_customers_a174652_pt2 WHERE FLD_CUSTOMER_ID = :cid");
    $stmt->bindParam(':cid', $cid, PDO::PARAM_INT);

    $cid = $_GET['edit'];
    $fid = sprintf("C%03d", $cid);

    $stmt->execute();

    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
  }

  catch(PDOException $e)
  {
    echo "Error: " . $e->getMessage();
  }
}

// GET NEXT ID
$cust = $conn->query("SHOW TABLE STATUS LIKE 'tbl_customers_a174652_pt2'")->fetch();
$NextID = sprintf("C%03d", $cust['Auto_increment']);

$conn = null;

?>