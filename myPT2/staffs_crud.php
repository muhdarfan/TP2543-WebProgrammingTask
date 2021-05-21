<?php

include_once 'database.php';

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Create
if (isset($_POST['create'])) {

  try {

    $stmt = $conn->prepare("INSERT INTO tbl_staffs_a174652_pt2(FLD_STAFF_NAME, FLD_STAFF_GENDER, fld_staff_phone) VALUES( :name, :gender, :phone)");

    //$stmt->bindParam(':sid', $sid, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

    //$sid = $_POST['sid'];
    $name = $_POST['name'];
    $gender =  $_POST['gender'];
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

    $stmt = $conn->prepare("UPDATE tbl_staffs_a174652_pt2 SET FLD_STAFF_ID = :sid, FLD_STAFF_NAME = :name, FLD_STAFF_GENDER = :gender, FLD_STAFF_PHONE = :phone WHERE FLD_STAFF_ID = :oldsid LIMIT 1");

    $stmt->bindParam(':sid', $sid, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':oldsid', $oldsid, PDO::PARAM_STR);

    $sid = $_POST['sid'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $oldsid = $_POST['oldsid'];

    $stmt->execute();

    header("Location: staffs.php");
  }

  catch(PDOException $e)
  {
    echo "Error: " . $e->getMessage();
  }
}

//Delete
if (isset($_GET['delete'])) {

  try {

    $stmt = $conn->prepare("DELETE FROM tbl_staffs_a174652_pt2 where FLD_STAFF_ID = :sid");

    $stmt->bindParam(':sid', $sid, PDO::PARAM_INT);

    $sid = $_GET['delete'];

    $stmt->execute();

    header("Location: staffs.php");
  }

  catch(PDOException $e)
  {
    echo "Error: " . $e->getMessage();
  }
}

//Edit
if (isset($_GET['edit'])) {

  try {

    $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a174652_pt2 where FLD_STAFF_ID = :sid");

    $stmt->bindParam(':sid', $sid, PDO::PARAM_INT);

    $sid = $_GET['edit'];
    $fid = sprintf("S%03d", $sid);

    $stmt->execute();

    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
  }

  catch(PDOException $e)
  {
    echo "Error: " . $e->getMessage();
  }
}

// GET NEXT ID
$staff = $conn->query("SHOW TABLE STATUS LIKE 'tbl_staffs_a174652_pt2'")->fetch();
$NextID = sprintf("S%03d", $staff['Auto_increment']);

$conn = null;

?>