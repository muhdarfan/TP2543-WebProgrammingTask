<?php
include_once 'database.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");

function uploadPhoto($file, $id)
{
    $target_dir = "products/";
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedExt = ['png', 'gif'];

    $newfilename = "{$id}.{$imageFileType}";

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
    if (!in_array($imageFileType, $allowedExt))
        return 2;

    if (!move_uploaded_file($file["tmp_name"], $target_dir . $newfilename))
        return 3;

    return array('status' => 200, 'name' => $newfilename, 'ext' => $imageFileType);
}

//Create
if (isset($_POST['create'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['FLD_STAFF_ROLE'] == 'admin') {
        $uploadStatus = uploadPhoto($_FILES['fileToUpload'], $_POST['pid']);

        if (isset($uploadStatus['status'])) {
            try {
                $stmt = $db->prepare("INSERT INTO tbl_products_a174652_pt2(FLD_PRODUCT_NAME, FLD_PRICE, FLD_BRAND, FLD_SOCKET, FLD_MANUFACTURED_YEAR, FLD_STOCK, FLD_PRODUCT_IMAGE)
               VALUES (:name, :price, :brand, :socket, :year, :stock, :image)");

                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':price', $price, PDO::PARAM_STR);
                $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
                $stmt->bindParam(':socket', $socket, PDO::PARAM_STR);
                $stmt->bindParam(':year', $year, PDO::PARAM_INT);
                $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
                $stmt->bindParam(':image', $uploadStatus['name']);

                $name = $_POST['name'];
                $price = $_POST['price'];
                $brand = $_POST['brand'];
                $socket = $_POST['socket'];
                $year = $_POST['year'];
                $stock = $_POST['stock'];

                $stmt->execute();

                clearstatcache();

                // Rename file after upload (IF NEEDED)
                //$id = $db->lastInsertId();
                //rename("products/{$uploadStatus['name']}", "products/{$id}.{$uploadStatus['ext']}");
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error while creating: " . $e->getMessage();
            }
        } else {
            if ($uploadStatus == 0)
                $_SESSION['error'] = "Please make sure the file uploaded is an image.";
            elseif ($uploadStatus == 1)
                $_SESSION['error'] = "Sorry, only file with below 10MB are allowed.";
            elseif ($uploadStatus == 2)
                $_SESSION['error'] = "Sorry, only PNG & GIF files are allowed.";
            elseif ($uploadStatus == 3)
                $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            elseif ($uploadStatus == 4)
                $_SESSION['error'] = 'Please upload an image.';
            else
                $_SESSION['error'] = "An unknown error has been occurred.";
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to create a new product.";
    }

    header("LOCATION: {$_SERVER['REQUEST_URI']}");
    exit();
}

//Update
if (isset($_POST['update'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['FLD_STAFF_ROLE'] == 'admin') {
        try {
            $stmt = $db->prepare("UPDATE tbl_products_a174652_pt2 SET
          FLD_PRODUCT_NAME = :name, FLD_PRICE = :price, FLD_BRAND = :brand,
          FLD_SOCKET = :socket, FLD_MANUFACTURED_YEAR = :year, FLD_STOCK = :stock
          WHERE FLD_PRODUCT_ID = :pid LIMIT 1");

            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
            $stmt->bindParam(':socket', $socket, PDO::PARAM_STR);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':pid', $pid);

            $name = $_POST['name'];
            $price = $_POST['price'];
            $brand = $_POST['brand'];
            $socket = $_POST['socket'];
            $year = $_POST['year'];
            $stock = $_POST['stock'];
            $pid = $_POST['pid'];

            $stmt->execute();

            // Image Upload
            $flag = uploadPhoto($_FILES['fileToUpload'], $pid);
            if (isset($flag['status'])) {
                $stmt = $db->prepare("UPDATE tbl_products_a174652_pt2 SET FLD_PRODUCT_IMAGE = :image WHERE FLD_PRODUCT_ID = :pid LIMIT 1");

                $stmt->bindParam(':image', $flag['name']);
                $stmt->bindParam(':pid', $pid);
                $stmt->execute();

                clearstatcache();

                // Rename file after upload (IF NEEDED)
                // rename("products/{$uploadStatus['name']}", "products/{$oldpid}.{$uploadStatus['ext']}");
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
            $_SESSION['error'] = "Error while updating: " . $e->getMessage();
        } catch (Exception $e) {
            $_SESSION['error'] = "Error while updating: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to update this product.";
        header("LOCATION: {$_SERVER['PHP_SELF']}");
        exit();
    }

    if (isset($_SESSION['error']))
        header("LOCATION: {$_SERVER['REQUEST_URI']}");
    else
        header("Location: {$_SERVER['PHP_SELF']}");

    exit();
}

// Hanya update bila tiada error. (IF NEEDED)
/*
if (isset($_POST['update'])) {
    try {
        // Image Upload
        $flag = uploadPhoto($_FILES['fileToUpload'], false);
        if (isset($flag['status']) || $flag == 4) {
            $sql = "UPDATE tbl_products_a174652_pt2 SET
                                    FLD_PRODUCT_NAME = :name, FLD_PRICE = :price, FLD_BRAND = :brand,
                                    FLD_SOCKET = :socket, FLD_MANUFACTURED_YEAR = :year, FLD_STOCK = :stock";

            if (isset($flag['status']))
                $sql .= ", FLD_PRODUCT_IMAGE = :image ";

            $sql .= "WHERE FLD_PRODUCT_ID = :oldpid LIMIT 1";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
            $stmt->bindParam(':socket', $socket, PDO::PARAM_STR);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':oldpid', $oldpid);

            $name = $_POST['name'];
            $price = $_POST['price'];
            $brand = $_POST['brand'];
            $socket = $_POST['socket'];
            $year = $_POST['year'];
            $stock = $_POST['stock'];
            $oldpid = $_POST['oldpid'];

            if (isset($flag['status']))
                $stmt->bindParam(':image', $flag['name']);

            $stmt->execute();
        } else {
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
*/

//Delete
if (isset($_GET['delete'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['FLD_STAFF_ROLE'] == 'admin') {
        try {
            $pid = $_GET['delete'];

            // Select Product Image Name
            $query = $db->query("SELECT FLD_PRODUCT_IMAGE FROM tbl_products_a174652_pt2 WHERE FLD_PRODUCT_ID = {$pid} LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            // Check if selected product id exists .
            if (isset($query['FLD_PRODUCT_IMAGE'])) {
                // Delete Query
                $stmt = $db->prepare("DELETE FROM tbl_products_a174652_pt2 WHERE FLD_PRODUCT_ID = :pid");
                $stmt->bindParam(':pid', $pid);

                $stmt->execute();

                // Delete Image
                unlink("products/{$query['FLD_PRODUCT_IMAGE']}");
            }

        } catch (PDOException $e) {
            $_SESSION['error'] = "Error while deleting: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to delete this product.";
    }

    header("LOCATION: {$_SERVER['PHP_SELF']}");
    exit();
}

//Edit
if (isset($_GET['edit'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['FLD_STAFF_ROLE'] == 'admin') {
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_products_a174652_pt2 WHERE FLD_PRODUCT_ID = :pid");
            $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
            $pid = $_GET['edit'];

            $stmt->execute();

            $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
            $fID = sprintf("MB%03d", $editrow['FLD_PRODUCT_ID']);

            if (empty($editrow['FLD_PRODUCT_IMAGE']))
                $editrow['FLD_PRODUCT_IMAGE'] = $editrow['FLD_PRODUCT_ID'] . '.png';
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to edit a product.";
    }

    if (isset($_SESSION['error'])) {
        header("LOCATION: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

// GET NEXT ID
$product = $db->query("SHOW TABLE STATUS LIKE 'tbl_products_a174652_pt2'")->fetch();
$NextID = sprintf("MB%03d", $product['Auto_increment']);

