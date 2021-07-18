<?php
require_once '../../database.php';

if (isset($_SESSION['loggedin']))
    header("LOCATION: index.php");

$db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['username'], $_POST['password'])) {
    $UserID = htmlspecialchars($_POST['username']);
    $Pass = $_POST['password'];

    if (empty($UserID) || empty($Pass)) {
        $_SESSION['error'] = 'Please fill in the blanks.';
    } else {
        $stmt = $db->prepare("SELECT * FROM tbl_staffs_a176875_pt2 WHERE (fld_staff_email = :id) LIMIT 1");
        $stmt->bindParam(':id', $UserID);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user['FLD_PASS'] == $Pass) {
            unset($user['FLD_PASS']);
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = $user;

            header("LOCATION: index.php");
            exit();
        } else {
            $_SESSION['error'] = 'Invalid login credentials. Please try again.';
        }
    }

    header("LOCATION: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Magzhive Magazine Store: Login</title>
    <!--  <link rel="shortcut icon" type="image/x-icon" href="images/sopico.ico"/>  -->
    <link href="login.css" rel="stylesheet">
    <!--    <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            width: 40%;
            position: relative;
            border-radius: 30px;

        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .container {
            padding: 2px 16px;
        }
    </style>
</head>
<body>
<div id="back">
    <canvas id="canvas" class="canvas-back"></canvas>
    <div class="backRight">
    </div>
    <div class="backLeft">
    </div>
</div>

<div id="slideBox">
    <div class="topLayer">
        <div class="left" style="overflow: hidden;">
            <div class="content">
                <center>
                    <h2 style="padding-top: 80px; color: #fae1dd;">Email Address Details</h2>
                </center>
                <form id="form-signup" method="post">
                    <div align="center" style="padding-top:10px;">


                        <div class="card form-element" style="background-color: white;">
                            <div class="container">
                                <h4>Admin</h4>
                                <hr>
                                <p>Jenna@magzhive.com</p>
                                <p>1234</p>
                            </div>
                        </div>


                        <div class="card form-element" style="background-color: white;">
                            <div class="container">
                                <h4>Staff</h4>
                                <hr>
                                <p>Rafael@magzhive.com</p>
                                <p>1234</p>
                            </div>
                        </div>


                    </div>
                    <div class="form-element form-submit" align="center">
                        <a href="#" id="goLeft" class="signup off" style="color: #F0F9F9;text-decoration: none;">Log
                            In</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="right" style="overflow: hidden;">
            <div class="content">
                <h2 style="color:black; font-weight: bold;">Login</h2>
                <form id="form-login" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <div class="form-element form-stack">
                        <label for="username-login" class="form-label">Username</label>
                        <input id="username-login" type="text" name="username">
                    </div>
                    <div class="form-element form-stack">
                        <label for="password-login" class="form-label">Password</label>
                        <input id="password-login" type="password" name="password">
                    </div>
                    <div class="form-element form-submit">
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo "<br><p class='alert alert-danger text-center' style='color:red;font-weight:bold'>{$_SESSION['error']}</p>";
                            unset($_SESSION['error']);
                        }
                        ?>
                        <button type="submit" name="login" style="background-color:black;color: #F0F9F9;">Log In
                        </button>
                        <a href="#" id="goRight" class="login off" name="signup"
                           style="color:black;text-decoration: none;">Read Me</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="js/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/paper.js/0.12.15/paper-full.min.js"
        integrity="sha512-ovjLI1ZcZe6bw+ImQ21r+sv8q/Vwob2kq7tFidK6E1LWfi0T4uobbmpfEU1//a9h9o5Kkt+MnMWf6rWlg0EiMw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/login.js"></script>
</body>
</html>
