<?php
require_once 'database.php';

if (isset($_SESSION['loggedin']))
    header("LOCATION: index.php");

if (isset($_POST['userid'], $_POST['password'])) {
    $UserID = htmlspecialchars($_POST['userid']);
    $Pass = $_POST['password'];

    if (empty($UserID) || empty($Pass)) {
        $_SESSION['error'] = 'Please fill in the blanks.';
    } else {
        $stmt = $db->prepare("SELECT * FROM tbl_staffs_a174652_pt2 WHERE (FLD_STAFF_ID = :id OR FLD_STAFF_EMAIL = :id) LIMIT 1");
        $stmt->bindParam(':id', $UserID);
        $stmt->bindParam(':pass', $Pass);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($user['FLD_STAFF_ID'])) {
            if ($user['FLD_STAFF_PASSWORD'] == $Pass) {
                unset($user['FLD_STAFF_PASSWORD']);
                $_SESSION['loggedin'] = true;
                $_SESSION['user'] = $user;

                header("LOCATION: index.php");
                exit();
            } else {
                $_SESSION['error'] = 'Invalid login credentials. Please try again.';
            }
        } else {
            $_SESSION['error'] = 'Account does not exist.';
        }
    }

    header("LOCATION: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>My Motherboard Ordering System : Login</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container login-wrapper">
    <div class="panel panel-default" style="width: 100%">
        <div class="panel-body">
            <div class="text-center">
                <h2 class="text-center">LOGIN</h2>
                Sign in to your account
            </div>
            <hr/>

            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                <div class="form-group">
                    <label for="inputUserID">Email address / User ID</label>
                    <input type="text" class="form-control" id="inputUserID" name="userid"
                           placeholder="Email address / User ID">
                </div>
                <div class="form-group">
                    <label for="inputUserPass">Password</label>
                    <input type="password" class="form-control" id="inputUserPass" name="password" placeholder="Password">
                </div>

                <?php
                if (isset($_SESSION['error'])) {
                    echo "<p class='text-danger text-center'>{$_SESSION['error']}</p>";
                    unset($_SESSION['error']);
                }
                ?>
                <button type="submit" class="btn btn-primary btn-block" style="border-radius: 20px;">Login</button>
            </form>

            <hr/>
            <p class="text-center">
                Don't have an account? Click <a href="register.php">here</a> to register.
            </p>
        </div>
    </div>

    <p style="color: #AAAAAA;">Copyright &copy; <?php echo date('Y'); ?> Arfan (<a
                target="_blank" href="http://lepak.xyz">@lepak.xyz)</a>. A174652</p>
</div>
</body>
</html>
