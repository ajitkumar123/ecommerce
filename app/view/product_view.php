<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dataweave Product(2016)</title>
    <!-- Bootstrap Core CSS -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="public/css/main.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="public/https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="public/https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:void(0)">Dataweave</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style=" float: right;">
            <form class="navbar-form" role="search">
                <div class="input-group">
                    <input type="text" class="form-control col-sm-12"
                           value="<?php echo isset($_GET['q']) ? $_GET['q'] : '' ?>"
                           style="width: 500px" placeholder="Search" id="search" name="q">

                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<!-- Page Content -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
                                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                        Category
                                    </a>
                                </h4>
                            </div>
                            <div id="sportswear" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <ul>
                                        <?php foreach ($filter['category'] as $category): ?>
                                            <li><a href="<?php echo Url::generate($current_url, 'category',
                                                    $category); ?>"><?php echo $category; ?> </a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($filter['subcategory'])): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordian" href="#mens">
                                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                            SubCategory
                                        </a>
                                    </h4>
                                </div>

                                <div id="mens" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="filters-wrapper">
                                            <div class="collapse in" id="app_status">
                                                <ul class="listing_filter">
                                                    <?php foreach ($filter['subcategory'] as $subcategory): ?>
                                                        <li class="checkbox">
                                                            <input type="checkbox" <?php echo (isset($selected_params['subcategory']) &&
                                                            in_array($subcategory, $selected_params['subcategory']) ? 'checked' : ''); ?>
                                                                   class="sub_category" id="<?php echo $subcategory; ?>" name="check"
                                                                   value="<?php echo $subcategory; ?>">
                                                            <label for="<?php echo $subcategory; ?>"><?php echo $subcategory; ?></label>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(isset($filter['brands'])): ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordian" href="#mens">
                                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                        Brands
                                    </a>
                                </h4>
                            </div>

                            <div id="mens" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="filters-wrapper brands_wrapper">
                                        <div class="collapse in" id="exam_type">
                                            <ul class="listing_filter">
                                                <?php foreach ($filter['brands'] as $brands): ?>
                                                    <li class="checkbox <?php echo $brands; ?>">
                                                        <input class="brands" id="<?php echo $brands; ?>"
                                                               <?php echo (isset($selected_params['brands']) &&
                                                               in_array($brands, $selected_params['brands']) ? 'checked' : ''); ?>
                                                               type="checkbox" name="check" value="<?php echo $brands; ?>">
                                                        <label for="<?php echo $brands; ?>"><?php echo $brands; ?></label>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div><!--/category-products-->
                    <div class="price-range"><!--price-range-->
                        <h4>Price Range</h4>

                        <div class="well text-center">
                            <table>
                                <tr>
                                    <td><label><span>₹</span></label></td>
                                    <td width="50%"><input style="width: 70px" type="text"
                                       value="<?php echo ( isset($selected_params['range']['low_price']) &&
                                            !empty($selected_params['range']['low_price']) ? $selected_params['range']['low_price'] : ''
                                       );?>" id="low-price"
                                       name="low-price" maxlength="9"></td>
                                    <td>&nbsp;to&nbsp;</td>
                                    <td><label><span>₹</span></label></td>
                                    <td width="50%"><input style="width: 70px" type="text"
                                       value="<?php echo ( isset($selected_params['range']['high_price']) &&
                                        !empty($selected_params['range']['high_price']) ? $selected_params['range']['high_price'] : ''
                                        );?>" id="high-price" name="high-price" maxlength="7"></td>
                                    <td><input type="image" id="range"
                                               src="http://g-ecx.images-amazon.com/images/G/31/shopping_engine/nav2/buttons/btn-gno-go-sm._CB341434301_.png"
                                               align="absbottom" alt="Go" title="Go"></td>
                                </tr>
                            </table>

                        </div>
                    </div><!--/price-range-->
                    <div class="collapse in" id="exam_type">
                        <ul class="listing_filter">
                                <h4>Availability</h4>
                                <li class="checkbox ">
                                    <input class="stock" id="stock"
                                        <?php echo (isset($selected_params['stock']) ? 'checked' : ''); ?>
                                           type="checkbox" name="check" value="yes">
                                    <label for="stock">Exclude Out of Stock</label>
                                </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h3 class="title text-center">Showing <?php echo (isset($selected_params['category']) ? urldecode($selected_params['category'])
                        : '');?> Items</h3>
                    <?php foreach ($list as $value): ?>
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center" style="height: 320px!important;">
                                        <img src="<?php echo $value->thumbnail ?>" alt="">

                                        <h2>₹<?php echo $value->available_price ?></h2>

                                        <p><?php echo $value->title ?></p>
                                        <a href="#" class="btn btn-default add-to-cart"><i
                                                class="fa fa-shopping-cart"></i>Add to cart</a>
                                    </div>
                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div><!--/category-tab-->
            </div>

        </div>

    </div>
</section>

<!-- /.container -->
<?php $total = ceil($total / 18);
$next = $page;
if ($page < $total) {
    $next = $page + 1;
} ?>
<?php $back = 1;
if ($page != 1) {
    $back = $page - 1;
} ?>
<?php $start_page = 1; ?>
<?php if ($page >= 3) {
    $start_page = $page - 3;
} elseif ($page >= 2) {
    $start_page = $page - 2;
} else {
    $start_page = $page - 1;
}
?>

<div class="container" style="text-align: center">

    <nav>
        <ul class="pagination">
            <li class="<?php if ($back == $page) {
                echo 'disabled';
            } ?>">
                <a href="<?php if ($back == 1 and $back == $page) {
                    echo '#';
                } else {
                    echo Url::generate($current_url, 'page', $back);
                } ?>"
                   aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
            <?php for ($i = $page; $i <= $total && $i < $page + 6; $i++): ?>
                <li class="<?php if ($i == $page) {
                    echo 'active';
                } ?>"><a href="<?php echo Url::generate($current_url, 'page', $i); ?>"><?php echo $i ?> <span
                            class="sr-only">(current)</span></a></li>
            <?php endfor ?>
            <li class="<?php if ($next == $page) {
                echo 'disabled';
            } ?>">
                <a href="<?php if ($next == 1 and $next == $page) {
                    echo '#';
                } else {
                    echo Url::generate($current_url, 'page', $next);
                } ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<script src="public/js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/main.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</body>
<footer>
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 ">
                    <h3> Find us at</h3>
                    <ul class="social">
                        <li> <a href="#"> <i class=" fa fa-facebook">   </i> </a> </li>
                        <li> <a href="#"> <i class="fa fa-twitter">   </i> </a> </li>
                        <li> <a href="#"> <i class="fa fa-google-plus">   </i> </a> </li>
                    </ul>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>
    <!--/.footer-->

    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"> Copyright © Dataweave. All right reserved. </p>
        </div>
    </div>
    <!--/.footer-bottom-->
</footer>
</html>