<?php
require 'database.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>My Motherboard Ordering System : Home</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php include_once 'nav_bar.php'; ?>

<section class="container-fluid" style="background: #131313;padding: 3rem;">
    <div class="container content">
        <div class="text-center" style="margin-bottom: 3rem;">
            <div class="row">
                <div class="col-md-12">
                    <h1>EagleZ Motherboard Ordering System</h1>
                    <hr style="border-top: 1px solid transparent;" />
                    <p class="text-muted">Search product by model, type, price or all three.</p>
                </div>
                <div class="col-md-12">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control text-center input-lg" id="inputSearch" name="search"
                                   placeholder="ASUS MAXIMUS VIII HERO ALPHA">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</body>
</html>
