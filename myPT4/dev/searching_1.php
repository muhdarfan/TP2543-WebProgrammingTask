<?php
include_once 'database.php';

session_start();

if (isset($_SESSION['fld_staff_num']) && isset($_SESSION['fld_staff_email'])) {
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>VHS Movies Flix System : Search Product</title>
        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            label {
                color: #FFFFFF;
            }
        </style>

    </head>
    <body background="background2.jpg">

    <?php include_once 'nav_bar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <div class="page-header">
                    <h2 style="color:#FFFFFF">Searching Product</h2>
                </div>
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="form-group">
                            <label for="inputKeyword">Insert keywords (Name,Genre,Rated)</label>
                            <input name="search" type="text" class="form-control" id="inputKeyword"
                                   placeholder="Example:Alice Adventure Not Rated" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button class="btn btn-default btn-lg" type="submit">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h2 style="color:#FFFFFF">Products Catalog</h2>
                </div>
                <table style="background-color:#C5C6D0" class="table table-striped table-bordered">
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Price (RM)</th>
                        <th>Genre</th>
                        <th>Rated</th>
                        <th>Description</th>
                        <th>Production Year</th>
                        <th></th>
                    </tr>
                    <tbody>
                    <?php
                    $result = array();

                    if (isset($_POST['search'])) {

                        $keywords = explode(" ", $_POST['search']);

                        if (count($keywords) == 3) {
                            try {
                                $name = "%" . $keywords[0] . "%";
                                $genre = "%" . $keywords[1] . "%";
                                $rated = "%" . $keywords[2] . "%";

                                $stmt = $conn->prepare("SELECT * FROM tbl_products_a182511_pt2 WHERE fld_product_name LIKE ? AND fld_genre LIKE ? AND fld_rated LIKE ? ORDER BY fld_product_num ASC");

                                $stmt->bind_param("sss", $name, $genre, $rated);
                                $stmt->execute();

                                $result = $stmt->get_result();
                            } catch (Exception $e) {
                                echo "<tr><td colspan='8'>No information available. <p class='text-danger'>An error occurred while processing. [{$e->getMessage()}]</p></td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No information available. <p class='text-danger'>Please check your search keywords.</p></td></tr>";
                        }
                    }

                    if (!empty($result)) {
                        while ($readrow = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $readrow['FLD_PRODUCT_ID']; ?></td>
                                <td><?php echo $readrow['fld_product_name']; ?></td>
                                <td><?php echo $readrow['FLD_PRICE']; ?></td>
                                <td><?php echo $readrow['fld_genre']; ?></td>
                                <td><?php echo $readrow['fld_rated']; ?></td>
                                <td><?php echo $readrow['fld_description']; ?></td>
                                <td><?php echo $readrow['fld_productionyear']; ?></td>
                                <td class="text-center">
                                    <a href="../products_details.php?pid=<?php echo $readrow['fld_product_num']; ?>"
                                       class="btn btn-warning btn-xs" role="button">Details</a>
                                    <button data-toggle="modal" data-target="#imageModal"
                                            data-img="<?php echo $readrow['fld_product_image']; ?>"
                                            data-name="<?php echo $readrow['fld_product_name']; ?>"
                                            class="btn btn-info btn-xs" role="button">Image
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='8'>No information available.</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="imageModalLabel" style="color: #0f0f0f;">Product Image</h4>
                </div>
                <div class="modal-body text-center">
                    <img class="product-image" src="../products/no-photo.png" alt="No Photo" class="img-rounded"
                         style="height: 500px;width: 500px;">
                </div>
                <div class="modal-footer" style="text-align: center !important;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>

    <script type="application/javascript">
        $('#imageModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const imgUrl = button.data('img');
            const productName = button.data('name');

            const modal = $(this);
            modal.find('.modal-title').text(`${productName}'s image`);
            modal.find('.product-image').prop('title', `${productName}'s image`);
            modal.find('.product-image').attr('src', 'products/' + imgUrl);
        });

        $('.product-image').on("error", function () {
            this.src = 'products/no-photo.png';
        });
    </script>
    </body>
    </html>
    <?php
} else {

    header("Location: index.php");
    exit();
}
?>
