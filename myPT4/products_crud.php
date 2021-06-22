<?php
include_once 'database.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function uploadPhoto($file)
{
    $target_dir = "products/";
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    /*
     * 0 = image file is a fake image
     * 1 = file already exists
     * 2 = file is too large.
     * 3 = PNG & GIF files are allowed
     * 4 = Server error
     */

    // Check if image file is a actual image or fake image
    if (getimagesize($file['tmp_name']))
        return 0;

    // Check if file already exists
    if (file_exists($target_file))
        return 1;

    // Check file size
    if ($file["size"] > 500000)
        return 2;

    // Allow certain file formats
    if ($imageFileType != "png" && $imageFileType != "gif")
        return 3;

    if (!move_uploaded_file($file["tmp_name"], $target_file))
        return 4;

    return 200;
}

//Create
if (isset($_POST['create'])) {
    $flag = uploadPhoto($_FILES['fileToUpload']);

    if ($flag == 200) {
        try {
            $stmt = $conn->prepare("INSERT INTO tbl_products_a174652_pt2(
      fld_product_name, fld_product_price, fld_product_brand, fld_product_condition,
      fld_product_year, fld_product_quantity) VALUES(:name, :price, :brand,
      :cond, :year, :quantity)");

            //$stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
            $stmt->bindParam(':socket', $socket, PDO::PARAM_STR);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);

            //$pid = $_POST['pid'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $brand = $_POST['brand'];
            $socket = $_POST['socket'];
            $year = $_POST['year'];
            $stock = $_POST['stock'];

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

//Update
if (isset($_POST['update'])) {
    try {
        $stmt = $conn->prepare("UPDATE tbl_products_a174652_pt2 SET
      FLD_PRODUCT_NAME = :name, FLD_PRICE = :price, FLD_BRAND = :brand,
      FLD_SOCKET = :socket, FLD_MANUFACTURED_YEAR = :year, FLD_STOCK = :stock
      WHERE FLD_PRODUCT_ID = :oldpid");

        //$stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':socket', $socket, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':oldpid', $oldpid, PDO::PARAM_STR);

        //$pid = $_POST['pid'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $brand = $_POST['brand'];
        $socket = $_POST['socket'];
        $year = $_POST['year'];
        $stock = $_POST['stock'];
        $oldpid = $_POST['oldpid'];

        $stmt->execute();

        header("Location: products.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

//Delete
if (isset($_GET['delete'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM tbl_products_a174652_pt2 WHERE FLD_PRODUCT_ID = :pid");
        $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
        $pid = $_GET['delete'];

        $stmt->execute();

        header("Location: products.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

//Edit
if (isset($_GET['edit'])) {
    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_products_a174652_pt2 WHERE FLD_PRODUCT_ID = :pid");
        $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
        $pid = $_GET['edit'];

        $stmt->execute();

        $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
        $fID = sprintf("MB%03d", $editrow['FLD_PRODUCT_ID']);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// GET NEXT ID
$product = $conn->query("SHOW TABLE STATUS LIKE 'tbl_products_a174652_pt2'")->fetch();
$NextID = sprintf("MB%03d", $product['Auto_increment']);

$conn = null;
?>