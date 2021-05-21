<?php
$lecturers = array (
    array('id' => "K004901", 'name' => "Prof. Dr. Abdullah Mohd Zin", 'room' => "BD, Block G (Level 1)", 'tel' => "+603-89216173", 'email' => "amzftsm@ukm.edu.my"),
    array('id' => "K012964", 'name' => "Prof. Dr. Azuraliza Abu Bakar", 'room' => "BTDR, Blok G (Level 1)", 'tel' => "+603-89216177", 'email' => "azuraliza@ukm.edu.my"),
    array('id' => "K009683", 'name' => "Assoc. Prof. Dr. Haslina Arshad", 'room' => "BTDS, Block A (Ground Floor)", 'tel' => "+603-89216812", 'email' => "haslinarshad@ukm.edu.my"),
    array('id' => "K007915", 'name' => "Assoc. Prof. Dr. Mohd Juzaiddin Ab Aziz", 'room' => "BTDP, Blok A (Level 1)", 'tel' => "+603-89216183", 'email' => "juzaiddin@ukm.edu.my")
);

if (isset($_GET['id']) && ($_GET['id'] != "")) {
    $id = $_GET['id'];
    $key = array_search($id, array_column($lecturers, 'id'));
}
else {
    echo "Error: You have execute a wrong PHP. Please contact the web administrator.";
    die();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lecturer Details</title>
</head>
<body>
    <h1><?php echo $lecturers[$key]['name']; ?></h1>
    <hr>
    <table border="1" cellpadding="10">
        <tr>
            <td colspan="2"><img src="<?php echo $lecturers[$key]['id']; ?>.jpg" width="300"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $lecturers[$key]['email']; ?></td>
        </tr>
        <tr>
            <td>Room</td>
            <td><?php echo $lecturers[$key]['room']; ?></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><?php echo $lecturers[$key]['tel']; ?></td>
        </tr>
    </table>
</body>

</html>