<?php

if (isset($_POST['biodata_form'])) {
    
    // initialize variables
    $name = "";
    $age = "";
    $sex = "";
    $address = "";
    $email = "";
    $dob = "";
    $height = "";
    $phone = "";
    $color = "";
    $fbtwig = "";
    $univ = "";
    $matricnum = "";
    $count_error = 0;
    $msg = "";
    
    // validate if submitted variables empty show error msg else put in local variables
    if (isset($_POST['name']) && ($_POST['name'] != "")) {
        $name = $_POST['name'];
    } else {
        $msg .= "Error: Please insert a name.<br>";
        $count_error++;
    }
    
    if (isset($_POST['age']) && ($_POST['age'] != "")) {
        $age = $_POST['age'];
    } else {
        $msg .= "Error: Please insert an age.<br>";
        $count_error++;
    }
    
    if (isset($_POST['sex']) && $_POST['sex'] != "") { 
        $sex = $_POST['sex'];
    } else {
        $msg .= "Error: Please select a sex.<br>";
        $count_error++;
    }
    
    if (isset($_POST['address']) && $_POST['address'] != "") { 
        $address = $_POST['address'];
    } else {
        $msg .= "Error: Please insert an address.<br>";
        $count_error++;
    }
    
    if (isset($_POST['email']) && $_POST['email'] != "") { 
        $email = $_POST['email'];
    } else {
        $msg .= "Error: Please insert an email.<br>";
        $count_error++;
    }
    
    if (isset($_POST['dob']) && $_POST['dob'] != "") { 
        $dob = $_POST['dob'];
    } else {
        $msg .= "Error: Please insert a date of birth.<br>";
        $count_error++;
    }
    
    if (isset($_POST['height']) && $_POST['height'] != "") { 
        $height = $_POST['height'];
    } else {
        $msg .= "Error: Please insert a height.<br>";
        $count_error++;
    }
    
    if (isset($_POST['phone']) && $_POST['phone'] != "") { 
        $phone = $_POST['phone'];
    } else {
        $msg .= "Error: Please insert a phone number.<br>";
        $count_error++;
    }
    
    if (isset($_POST['color']) && $_POST['color'] != "") { 
        $color = $_POST['color'];
    } else {
        $msg .= "Error: Please insert a color.<br>";
        $count_error++;
    }
    
    if (isset($_POST['fbtwig']) && $_POST['fbtwig'] != "") { 
        $fbtwig = $_POST['fbtwig'];
    } else {
        $msg .= "Error: Please insert a FB/TW/IG URL.<br>";
        $count_error++;
    }
    
    if (isset($_POST['university']) && $_POST['university'] != "") { 
        $univ = $_POST['university'];
    } else {
        $msg .= "Error: Please select a university.<br>";
        $count_error++;
    }
    
    if (isset($_POST['matricnum']) && $_POST['matricnum'] != "") { 
        $matricnum = $_POST['matricnum'];
    } else {
        $msg .= "Error: Please insert a matric number.<br>";
        $count_error++;
    }
    // more validations here
    
    if ($count_error > 0) {
        // display error(s) here and stop
        echo $msg;
        echo "$count_error error(s) detected.";
        die();
    }
}
else {
    echo "Error: You have execute a wrong PHP. Please contact the web administrator.";
    die();
}

function titleCase($s) {
    $s = ucwords(strtolower($s));
    return $s;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Biodata</title>
</head>

<body>
    <h1>Validate Biodata</h1>
    <hr>
    <form action="save_biodata.php" method="post">
        <table border="1" cellpadding="10">
            <tr>
                <td>Name:</td>
                <td><?php echo titleCase($name); ?><input type="hidden" name="name" value="<?php echo $name; ?>"></td>
            </tr>
            <tr>
                <td>Age:</td>
                <td><?php echo $age; ?><input type="hidden" name="age" value="<?php echo $age; ?>"></td>
            </tr>
            <tr>
                <td>Sex:</td>
                <td><?php echo $sex; ?><input type="hidden" name="sex" value="<?php echo $sex; ?>"></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><?php echo $address; ?><input type="hidden" name="address" value="<?php echo $address; ?>"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $email; ?><input type="hidden" name="email" value="<?php echo $email; ?>"></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td><?php echo date("d-m-Y", strtotime($dob)); ?><input type="hidden" name="dob"
                        value="<?php echo $dob; ?>"></td>
            </tr>
            <tr>
                <td>Height:</td>
                <td><?php echo $height; ?><input type="hidden" name="height" value="<?php echo $height; ?>"></td>
            </tr>
            <tr>
                <td>Tel:</td>
                <td><?php echo $phone; ?><input type="hidden" name="phone" value="<?php echo $phone; ?>"></td>
            </tr>
            <tr>
                <td>My Favorite Color:</td>
                <td><?php echo $color; ?><input type="hidden" name="color" value="<?php echo $color; ?>"></td>
            </tr>
            <tr>
                <td>Fb/TW/IG:</td>
                <td><?php echo $fbtwig; ?><input type="hidden" name="fbtwig" value="<?php echo $fbtwig; ?>"></td>
            </tr>
            <tr>
                <td>My University:</td>
                <td><?php echo $univ; ?><input type="hidden" name="univ" value="<?php echo $univ; ?>"></td>
            </tr>
            <tr>
                <td>My Matric Number:</td>
                <td><?php echo $matricnum; ?></td>
            </tr>
        </table>
        <hr>
        <input type="hidden" name="matricnum" value="<?php echo $matricnum; ?>">
        <input type="submit" name="biodata_validate" value="Save My Biodata">
    </form>

</body>

</html>