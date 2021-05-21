<?php

if (isset($_POST['biodata_validate'])) {
    
    $name = $_POST['name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $height = $_POST['height'];
    $phone = $_POST['phone'];
    $color = $_POST['color'];
    $fbtwig = $_POST['fbtwig'];
    $univ = $_POST['univ'];
    $matricnum = $_POST['matricnum'];
    
    $sql = "insert into biodata(";
    $sql = $sql."name, ";
    $sql = $sql."age, ";
    $sql = $sql."sex, ";
    $sql = $sql."address, ";
    $sql = $sql."email, ";
    $sql = $sql."dob, ";
    $sql = $sql."height, ";
    $sql = $sql."phone, ";
    $sql = $sql."color, ";
    $sql = $sql."fbtwig, ";
    $sql = $sql."univ, ";
    $sql = $sql."matricnum) values(";
    $sql = $sql."'".$name."', ";
    $sql = $sql.$age.", ";
    $sql = $sql."'".$sex."', ";
    $sql = $sql."'".$address."', ";
    $sql = $sql."'".$email."', ";
    $sql = $sql."'".$dob."', ";
    $sql = $sql.$height.", ";
    $sql = $sql."'".$phone."', ";
    $sql = $sql."'".$color."', ";
    $sql = $sql."'".$fbtwig."', ";
    $sql = $sql."'".$univ."', ";
    $sql = $sql."'".$matricnum."')";
    
    echo $sql;
    
}

?>