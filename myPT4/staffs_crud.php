<?php
include_once 'database.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Create
if (isset($_POST['create'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['FLD_STAFF_ROLE'] == 'admin') {
        try {
            $stmt = $conn->prepare("INSERT INTO tbl_staffs_a174652_pt2(FLD_STAFF_NAME, 
      FLD_STAFF_GENDER, FLD_STAFF_EMAIL, FLD_STAFF_PASSWORD, FLD_STAFF_PHONE, FLD_STAFF_ROLE) VALUES(:name, :gender, :email, :pass, :phone, :role)");

            //$stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);

            //$sid = $_POST['sid'];
            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $phone = $_POST['phone'];
            $role = $_POST['role'];

            $stmt->execute();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error while creating: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to create a new staff.";
    }

    header("LOCATION: {$_SERVER['REQUEST_URI']}");
    exit();
}

//Update
if (isset($_POST['update'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['FLD_STAFF_ROLE'] == 'admin') {
        try {
            $stmt = $conn->prepare("UPDATE tbl_staffs_a174652_pt2 SET FLD_STAFF_NAME = :name, FLD_STAFF_GENDER = :gender, FLD_STAFF_PHONE = :phone, FLD_STAFF_EMAIL = :email, FLD_STAFF_PASSWORD = :pass, FLD_STAFF_ROLE = :role WHERE FLD_STAFF_ID = :oldsid");

            //$stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->bindParam(':oldsid', $oldsid, PDO::PARAM_STR);

            //$sid = $_POST['sid'];
            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $role = $_POST['role'];
            $oldsid = $_POST['oldsid'];

            $stmt->execute();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error while updating: " . $e->getMessage();
            header("LOCATION: {$_SERVER['REQUEST_URI']}");
            exit();
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to update staff.";
    }

    header("LOCATION: {$_SERVER['PHP_SELF']}");
    exit();
}

//Delete
if (isset($_GET['delete'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['FLD_STAFF_ROLE'] == 'admin') {
        try {
            $stmt = $conn->prepare("DELETE FROM tbl_staffs_a174652_pt2 where FLD_STAFF_ID = :sid");
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);

            $sid = $_GET['delete'];

            $stmt->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to delete staff.";
    }

    header("LOCATION: {$_SERVER['PHP_SELF']}");
    exit();
}

//Edit
if (isset($_GET['edit'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['FLD_STAFF_ROLE'] == 'admin') {
        try {
            $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a174652_pt2 where FLD_STAFF_ID = :sid");
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);

            $sid = $_GET['edit'];
            $fid = sprintf("S%03d", $sid);

            $stmt->execute();

            $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("LOCATION: {$_SERVER['PHP_SELF']}");
            exit();
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to edit a staff.";
        header("LOCATION: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

// GET NEXT ID
$staff = $conn->query("SHOW TABLE STATUS LIKE 'tbl_staffs_a174652_pt2'")->fetch();
$NextID = sprintf("S%03d", $staff['Auto_increment']);

$conn = null;
