<?php
if (isset($_SESSION['loggedin']))
    header("LOCATION: index.php");


?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>EagleZ Inventory System : Register</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">

    <link rel="shortcut icon" type="image/jpg" href="favicon.ico" />

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
                <h2 class="text-center">REGISTER</h2>
                Create a new account
            </div>
            <hr/>

            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <div class="form-group">
                    <label for="inputUserID">Staff ID</label>
                    <input type="text" class="form-control" id="inputUserID" name="userid"
                           placeholder="Email address">
                </div>

                <div class="form-group">
                    <label for="inputEmail">Email address</label>
                    <input type="text" class="form-control" id="inputEmail" name="email"
                           placeholder="Email address">
                </div>

                <div class="form-group">
                    <label for="inputFullName">Full Name</label>
                    <input type="text" class="form-control" id="inputFullName" name="fullname" placeholder="Full Name">
                </div>

                <div class="form-group">
                    <label for="inputUserPass">Password</label>
                    <input type="password" class="form-control" id="inputUserPass" name="password"
                           placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="inputUserConfirmPass">Confirm Password</label>
                    <input type="password" class="form-control" id="inputUserConfirmPass" name="confirm_password"
                           placeholder="Confirm Password">
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="border-radius: 20px;">
                    Register
                </button>
            </form>

            <hr/>
            <p class="text-center">
                Already have an account? Click <a href="login.php">here</a> to login.
            </p>
        </div>
    </div>
</div>
</body>
</html>
