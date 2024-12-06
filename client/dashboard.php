<?php
session_start();
include('../config/config.php');
require_once('../config/checklogin.php');
client();
include_once('../partials/client_analytics.php');
require_once('../partials/head.php');
?>

<body>

    <!-- Navigation Bar-->
    <?php require_once("../partials/client_nav.php"); ?>
    <!-- End Navigation Bar-->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="wrapper">
        <div class="container">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group float-right m-t-15">

                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card-box tilebox-one">
                        <i class="zmdi zmdi-traffic float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase m-b-20">Available Parking Lots</h6>
                        <h2 class="m-b-20" data-plugin="counterup"><?php echo $parking_lots; ?></h2>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card-box tilebox-one">
                        <i class="zmdi zmdi-money-box float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase m-b-20">My Reservations</h6>
                        <h2 class="m-b-20"> <span data-plugin="counterup"><?php echo $reservations; ?></span></h2>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card-box tilebox-one">
                        <i class="zmdi zmdi-money-box float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase m-b-20">My Reservations Payments</h6>
                        <h2 class="m-b-20">Ksh <span data-plugin="counterup"><?php echo $reservations_revenue; ?></span></h2>
                    </div>
                </div>
            </div>
            <!-- end row -->


           
                       
        </div>

        <!-- Footer -->
        <?php require_once("../partials/footer.php"); ?>
        <!-- End Footer -->
    </div> <!-- End wrapper -->
    <?php require_once("../partials/scripts.php"); ?>
</body>

</html>