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
    <title>EagleZ Inventory System : Login</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">

    <link rel="shortcut icon" type="image/jpg" href="favicon.ico"/>

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
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" id="inputUserID" name="userid"
                               placeholder="Email address / User ID">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUserPass">Password</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" id="inputUserPass" name="password"
                               placeholder="Password">
                    </div>
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
                <!-- Don't have an account? Click <a href="register.php">here</a> to register.<br/> -->
                Click <a href="#" data-toggle="modal" data-target="#demoAccountModal">here</a> to retrieve demo account.
            </p>
        </div>
    </div>

    <p style="color: #AAAAAA;">Copyright &copy; <?php echo date('Y'); ?> Arfan (<a
                target="_blank" href="http://lepak.xyz">@lepak.xyz</a>) &ndash; A174652</p>
</div>

<div class="modal fade" id="demoAccountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Demo Account</h4>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <div href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">Admin Account</h4>
                        <p class="list-group-item-text">
                        <dl class="dl-horizontal">
                            <dt>Staff ID</dt>
                            <dd>1</dd>
                            <dt>Email</dt>
                            <dd>ali@ukm.my</dd>
                            <dt>Password</dt>
                            <dd>1234</dd>
                        </dl>
                        </p>
                    </div>

                    <div href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">Normal Staff Account</h4>
                        <p class="list-group-item-text">
                        <dl class="dl-horizontal">
                            <dt>Staff ID</dt>
                            <dd>2</dd>
                            <dt>Email</dt>
                            <dd>syafiqah@ukm.my</dd>
                            <dt>Password</dt>
                            <dd>password</dd>
                        </dl>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
