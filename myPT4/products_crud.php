<?php
include_once 'database.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");

function uploadPhoto($file)
{
    $target_dir = "products/";
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    /*
     * 0 = image file is a fake image
     * 1 = file is too large.
     * 2 = PNG & GIF files are allowed
     * 3 = Server error
     * 4 = No file were uploaded
     */

    if ($file['error'] == 4)
        return 4;

    // Check if image file is a actual image or fake image
    if (!getimagesize($file['tmp_name']))
        return 0;

    // Check file size
    if ($file["size"] > 10000000)
        return 1;

    // Allow certain file formats
    if ($imageFileType != "png" && $imageFileType != "gif")
        return 2;

    if (!move_uploaded_file($file["tmp_name"], $target_file))
        return 3;

    return array('status' => 200, 'name' => basename($file["name"]));
}

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Create
if (isset($_POST['create'])) {
    $flag = uploadPhoto($_FILES['fileToUpload']);

    if (isset($flag['status'])) {
        try {
            $stmt = $conn->prepare("INSERT INTO tbl_products_a174652_pt2(FLD_PRODUCT_NAME, FLD_PRICE, FLD_BRAND, FLD_SOCKET, FLD_MANUFACTURED_YEAR, FLD_STOCK, FLD_PRODUCT_IMAGE)
 VALUES (:name, :price, :brand, :socket, :year, :stock, :image)");

            //$stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
            $stmt->bindParam(':socket', $socket, PDO::PARAM_STR);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':image', $flag['name']);

            //$pid = $_POST['pid'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $brand = $_POST['brand'];
            $socket = $_POST['socket'];
            $year = $_POST['year'];
            $stock = $_POST['stock'];

            $stmt->execute();
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    } else {
        if ($flag == 0)
            $_SESSION['error'] = "Please make sure the file uploaded is an image.";
        elseif ($flag == 1)
            $_SESSION['error'] = "Sorry, only file with below 10MB are allowed.";
        elseif ($flag == 2)
            $_SESSION['error'] = "Sorry, only PNG & GIF files are allowed.";
        elseif ($flag == 3)
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
        elseif ($flag == 4)
            $_SESSION['error'] = 'Please upload an image.';
        else
            $_SESSION['error'] = "An unknown error has been occurred.";
    }

    header("LOCATION: {$_SERVER['REQUEST_URI']}");
    exit();
}

//Update
if (isset($_POST['update'])) {
    try {
        $stmt = $conn->prepare("UPDATE tbl_products_a174652_pt2 SET
      FLD_PRODUCT_NAME = :name, FLD_PRICE = :price, FLD_BRAND = :brand,
      FLD_SOCKET = :socket, FLD_MANUFACTURED_YEAR = :year, FLD_STOCK = :stock
      WHERE FLD_PRODUCT_ID = :oldpid LIMIT 1");

        //$stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':socket', $socket, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':oldpid', $oldpid);

        //$pid = $_POST['pid'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $brand = $_POST['brand'];
        $socket = $_POST['socket'];
        $year = $_POST['year'];
        $stock = $_POST['stock'];
        $oldpid = $_POST['oldpid'];

        $stmt->execute();

        // Image Upload
        $flag = uploadPhoto($_FILES['fileToUpload']);
        if (isset($flag['status'])) {
            $stmt = $conn->prepare("UPDATE tbl_products_a174652_pt2 SET FLD_PRODUCT_IMAGE = :image WHERE FLD_PRODUCT_ID = :oldpid LIMIT 1");

            $stmt->bindParam(':image', $flag['name']);
            $stmt->bindParam(':oldpid', $oldpid);
            $stmt->execute();
        } elseif ($flag != 4) {
            if ($flag == 0)
                $_SESSION['error'] = "Please make sure the file uploaded is an image.";
            elseif ($flag == 1)
                $_SESSION['error'] = "Sorry, only file with below 10MB are allowed.";
            elseif ($flag == 2)
                $_SESSION['error'] = "Sorry, only PNG & GIF files are allowed.";
            elseif ($flag == 3)
                $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            else
                $_SESSION['error'] = "An unknown error has been occurred.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    if (isset($_SESSION['error']))
        header("LOCATION: {$_SERVER['REQUEST_URI']}");
    else
        header("Location: products.php");

    exit();
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

        if (empty($editrow['FLD_PRODUCT_IMAGE']))
            $editrow['FLD_PRODUCT_IMAGE'] = $editrow['FLD_PRODUCT_ID'] . '.png';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// GET NEXT ID
$product = $conn->query("SHOW TABLE STATUS LIKE 'tbl_products_a174652_pt2'")->fetch();
$NextID = sprintf("MB%03d", $product['Auto_increment']);

$conn = null;
?>
