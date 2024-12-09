
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">


<!-- Mirrored from themesflat.co/html/ecomus/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Nov 2024 14:40:41 GMT -->
<head>
    <meta charset="utf-8">
    <title>Fsport</title>

    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

   <!-- font -->
   <link rel="stylesheet" href="assets/Users/fonts/fonts.css">
   <link rel="stylesheet" href="assets/Users/fonts/font-icons.css">
   <link rel="stylesheet" href="assets/Users/css/bootstrap.min.css">
   <link rel="stylesheet" href="assets/Users/css/swiper-bundle.min.css">
   <link rel="stylesheet" href="assets/Users/css/animate.css">
   <link rel="stylesheet"type="text/css" href="assets/Users/css/styles.css"/>

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="assets/Users/images/logo/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/Users/images/logo/favicon.png">
    <style>
        .header-default {
            margin-bottom: 0 !important;
        }
    </style>
</head>

<body class="preload-wrapper popup-loader">

    <!-- RTL -->
    <a href="javascript:void(0);" id="toggle-rtl" class="tf-btn animate-hover-btn btn-fill">RTL</a>
    <!-- /RTL  -->

    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div id="wrapper">
        <!-- Header -->
        <?php include 'app/Views/Users/layout/header.php' ?>
        <!-- /Header -->
        <div class="tf-page-title style-2">
            <div class="container-full">
                <div class="heading text-center">Order</div>
            </div>
        </div>
        
        <section class="flat-spacing-11">
        <div class="container">
            <table class="tf-table-page-cart">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($orders as $key => $value): ?>
                    <tr>
                        <td class="text-center"><?= $key + 1 ?></td>
                        <td class="text-center"><?= $value->name ?></td>
                        <td class="text-center"><?= $value->phone ?></td>
                        <td class="text-center"><?= $value->address ?></td>
                        <td class="text-center"><?= number_format($value->total) ?>VNĐ</td>
                        <td class="text-center"><?php
                            if($value->status == 'pending'):?>
                            <span class="badge text-bg-warning">Chờ xử lý</span>
                            <?php elseif ($value->status == 'completed'): ?>
                                <span class="badge text-bg-success">Đã hoàn thành</span>
                                <?php elseif ($value->status == 'canceled'): ?>
                                    <span class="badge text-bg-danger">Đã hủy</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>?act=show-order-detail&order_id=<?= $value->id ?>" class="btn btn-success text-center">Order Detail</a>
                            <?php
                            if($value->status == 'pending'):?>
                            <a href="<?= BASE_URL ?>?act=cancel-order&order_id=<?= $value->id ?>" class="btn btn-danger text-center" onclick="return confirm('Bạn chắc có muốn hủy đơn không')">Cancel</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

        <!-- Footer -->
        <?php include 'app/Views/Users/layout/footer.php' ?>
        <!-- /Footer -->
        
    </div>
     

    <!-- gotop -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;"></path>
        </svg>
    </div>
    <!-- /gotop -->
    

    <!-- Javascript -->
    <script type="text/javascript" src="assets/Users/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/carousel.js"></script>
    <script type="text/javascript" src="assets/Users/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/lazysize.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/count-down.js"></script>
    <script type="text/javascript" src="assets/Users/js/wow.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/multiple-modal.js"></script>
    <script type="text/javascript" src="assets/Users/js/main.js"></script>

   
</body>


<!-- Mirrored from themesflat.co/html/ecomus/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Nov 2024 14:42:11 GMT -->
</html>