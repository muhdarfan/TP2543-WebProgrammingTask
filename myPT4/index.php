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
<?php include_once 'nav_bar.inc'; ?>

<section class="container-fluid" style="background: #1E2C4E;padding: 3rem;">
    <div class="container content">
        <div class="text-center" style="margin-bottom: 3rem;">
            <div class="row">
                <div class="col-md-12">
                    <h1>EagleZ Motherboard Ordering System</h1>
                    <hr style="border-top: 1px solid transparent;"/>
                    <p class="text-muted">Search product by model, type, price or all three.</p>
                </div>
                <div class="col-md-12">
                    <form action="#" method="POST" id="searchForm">
                        <div class="form-group">
                            <input type="text" class="form-control text-center input-lg" id="inputSearch" name="search"
                                   placeholder="ASUS MAXIMUS 93.00 Asus" autocomplete="off" required>
                            <span id="helpBlock2" class="help-block"></span>
                        </div>

                        <button type="submit" class="btn btn-lg btn-primary">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container resultList" style="padding: 20px;display: none;">
    <div class="text-center">
        <h2>Result</h2>
        <p>Found <span class="result-count">0</span> results.</p>
    </div>

    <div class="row list-item"></div>
</section>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script>
    $("#searchForm").submit(function (e) {
        e.preventDefault();

        var input = $("#inputSearch");
        var val = input.val();

        input.parent().removeClass('has-error');
        input.parent().find("#helpBlock2").text("");

        if (val.length > 2) {
            $.get('ajax/search.php', {search: val}).done(function (res) {
                $('.list-item').empty();

                if (res.status == 200) {
                    $(".result-count").text(res.data.length);

                    $.each(res.data, function (idx, data) {
                        if (data.FLD_PRODUCT_IMAGE === '')
                            data.FLD_PRODUCT_IMAGE = data.FLD_PRODUCT_ID + '.png';

                        $('.list-item').append(`<div class="col-md-4">
            <div class="thumbnail">
                <img src="products/${data.FLD_PRODUCT_IMAGE}" alt="${data.FLD_PRODUCT_NAME}" style="height: 345px;">
                <div class="caption text-center">
                    <h3>${data.FLD_PRODUCT_NAME}</h3>
                    <p>
                        <a href="products_details.php?pid=${data.FLD_PRODUCT_ID}" class="btn btn-primary" role="button">View</a>
                    </p>
                </div>
            </div>
        </div>`);
                    });
                }
            });

            $(".resultList").show("slow");
        } else {
            input.parent().addClass("has-error");
            input.parent().find("#helpBlock2").text("Please enter more than 2 characters.");

            $('.list-item').empty();
        }
    });
</script>

</body>
</html>
