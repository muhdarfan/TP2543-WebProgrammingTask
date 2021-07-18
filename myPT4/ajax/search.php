<?php
header("Content-Type: application/json;Charset=UTF-8");
require '../database.php';

$Json = array();

if (isset($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);
    $data = explode(" ", $search);

    // 0 - name
    // 1 - price
    // 2 - brand

    $name = (isset($data[0]) ? "%{$data[0]}%" : '');
    $price = (isset($data[1]) ? "%{$data[1]}%" : '');
    $brand = (isset($data[2]) ? "%{$data[2]}%" : '');

    try {
        if (count($data) == 3) {
            $stmt = $db->prepare("SELECT * FROM tbl_products_a174652_pt2 WHERE FLD_BRAND LIKE :name AND FLD_PRICE LIKE :price AND FLD_SOCKET LIKE :brand");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":brand", $brand);
        } elseif (count($data) == 1) {
            $stmt = $db->prepare("SELECT * FROM `tbl_products_a174652_pt2` WHERE FLD_PRODUCT_NAME LIKE :param OR FLD_PRICE LIKE :param OR FLD_BRAND LIKE :param ORDER BY FLD_PRODUCT_ID ASC");
            $stmt->bindParam(":param", $name);
        } else {
            echo json_encode(array('status' => 401, 'data' => 'Please input 1 words or 3 words.'));
            exit();
        }

        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $Json = array('status' => 200, 'data' => $res);
    } catch (PDOException $e) {
        $Json = array('status' => 400, 'data' => $e->getMessage());
    }

}

if (isset($Json))
    echo json_encode($Json);
