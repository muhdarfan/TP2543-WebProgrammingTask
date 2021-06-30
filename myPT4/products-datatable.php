<?php
include_once 'products_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>EagleZ Inventory System : Products</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/>


    <style>
        input[type="file"] {
            display: none;
        }
    </style>
</head>
<body>
<?php include_once 'nav_bar.inc'; ?>
<?php
if (isset($_SESSION['user']) && $_SESSION['user']['FLD_STAFF_ROLE'] == 'admin') {
    ?>
    <div class="container-fluid dark" style="padding-bottom: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <?php
                        if (isset($editrow) && count($editrow) > 0) {
                            echo "<h2>Editing #" . $fID . "</h2>";
                        } else {
                            echo "<h2>Create New Product</h2>";
                        }
                        ?>
                    </div>
                </div>

                <form action="products.php" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="col-md-8">
                        <?php
                        if (isset($_GET['edit']))
                            echo "<input type='hidden' name='pid' value='" . $editrow['FLD_PRODUCT_ID'] . "' />";
                        ?>

                        <div class="form-group">
                            <label for="productid" class="col-sm-3 control-label">ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="productid" placeholder="Product ID"
                                       value="<?php if (isset($_GET['edit'])) echo $fID; else echo $NextID; ?>" readonly
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="productname" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input name="name" type="text" class="form-control" id="productname"
                                       placeholder="Product Name"
                                       value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_NAME']; ?>"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="productprice" class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-9">
                                <input name="price" type="number" class="form-control" id="productprice"
                                       placeholder="Product Price"
                                       value="<?php if (isset($_GET['edit'])) echo number_format($editrow['FLD_PRICE'], 2); ?>"
                                       min="0.0" step="0.01" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="productbrand" class="col-sm-3 control-label">Brand</label>
                            <div class="col-sm-9">
                                <select name="brand" class="form-control" id="productbrand" required>
                                    <option value="">Please select</option>
                                    <option value="Asrock" <?php if (isset($_GET['edit'])) if ($editrow['FLD_BRAND'] == "Asrock") echo "selected"; ?>>
                                        Asrock
                                    </option>
                                    <option value="Asus" <?php if (isset($_GET['edit'])) if ($editrow['FLD_BRAND'] == "Asus") echo "selected"; ?>>
                                        Asus
                                    </option>
                                    <option value="Biostar" <?php if (isset($_GET['edit'])) if ($editrow['FLD_BRAND'] == "Biostar") echo "selected"; ?>>
                                        Biostar
                                    </option>
                                    <option value="Gigabyte" <?php if (isset($_GET['edit'])) if ($editrow['FLD_BRAND'] == "Gigabyte") echo "selected"; ?>>
                                        Gigabyte
                                    </option>
                                    <option value="MSI" <?php if (isset($_GET['edit'])) if ($editrow['FLD_BRAND'] == "MSI") echo "selected"; ?>>
                                        MSI
                                    </option>
                                    <option value="Maxsun" <?php if (isset($_GET['edit'])) if ($editrow['FLD_BRAND'] == "Maxsun") echo "selected"; ?>>
                                        Maxsun
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="productsocket" class="col-sm-3 control-label">Socket</label>
                            <div class="col-sm-9">
                                <input name="socket" type="text" class="form-control" id="productsocket"
                                       placeholder="Product Socket"
                                       value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_SOCKET']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="productyear" class="col-sm-3 control-label">Manufacturing Year</label>
                            <div class="col-sm-9">
                                <select name="year" class="form-control" id="productyear" required>
                                    <option value="">Please select</option>
                                    <?php
                                    foreach (range(date('Y'), 2000) as $year) {
                                        echo "<option value='{$year}' " . ($year == $editrow['FLD_MANUFACTURED_YEAR'] ? 'selected' : '') . ">{$year}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="productstock" class="col-sm-3 control-label">Stock</label>
                            <div class="col-sm-9">
                                <input name="stock" type="number" class="form-control" id="productstock"
                                       placeholder="Product Socket"
                                       value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_STOCK']; ?>" min="0"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <?php if (isset($_GET['edit'])) { ?>
                                    <input type="hidden" name="oldpid"
                                           value="<?php echo $editrow['FLD_PRODUCT_ID']; ?>">
                                    <button class="btn btn-default" type="submit" name="update"><span
                                                class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update
                                    </button>
                                <?php } else { ?>
                                    <button class="btn btn-default" type="submit" name="create"><span
                                                class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create
                                    </button>
                                <?php } ?>
                                <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase"
                                                                                   aria-hidden="true"></span> Clear
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4" style="height: 100%">
                        <div class="thumbnail dark-1">
                            <img src="products/no-photo.png" id="productPhoto" alt="Product Image"
                                 style="width: 100%;height: 225px;">
                            <div class="caption text-center">
                                <h3 id="productImageTitle" style="word-break: break-all;">Product Image</h3>
                                <p>
                                    <label class="btn btn-primary">
                                        <input type="file" accept="image/*" name="fileToUpload" id="inputImage"
                                               onchange="loadFile(event);"/>
                                        <i class="fa fa-cloud-upload"></i> Upload
                                    </label>
                                    <?php
                                    if (isset($_GET['edit']) && $editrow['FLD_PRODUCT_IMAGE'] != '') {
                                        echo '<a href="#" class="btn btn-danger disabled" role="button">Delete</a>';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php } ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <div class="page-header">
                <h2>Products List</h2>
            </div>

            <table id="productList" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Brand</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>


                <?php
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("select * from tbl_products_a174652_pt2");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                foreach ($result as $readrow) {
                    ?>
                    <tr>
                        <td><?php echo $readrow['FLD_PRODUCT_ID']; ?></td>
                        <td><?php echo $readrow['FLD_PRODUCT_NAME']; ?></td>
                        <td>RM <?php echo $readrow['FLD_PRICE']; ?></td>
                        <td><?php echo $readrow['FLD_BRAND']; ?></td>
                        <td class="text-center">
                            <a href="products_details.php?pid=<?php echo $readrow['FLD_PRODUCT_ID']; ?>"
                               class="btn btn-warning btn-xs" role="button">Details</a>
                            <?php
                            if (isset($_SESSION['user']) && $_SESSION['user']['FLD_STAFF_ROLE'] == 'admin') {
                                ?>
                                <a href="products.php?edit=<?php echo $readrow['FLD_PRODUCT_ID']; ?>"
                                   class="btn btn-success btn-xs" role="button"> Edit </a>
                                <a href="products.php?delete=<?php echo $readrow['FLD_PRODUCT_ID']; ?>"
                                   onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"
                                   role="button">Delete</a>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script type="application/javascript">
    var loadFile = function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('productPhoto');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
        document.getElementById('productImageTitle').innerText = event.target.files[0]['name'];
    };

    $(document).ready(function () {
        $("#productList").DataTable();
    });
</script>
</body>
</html>
