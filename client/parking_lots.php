<?php
session_start();
include('../config/config.php');
require_once('../config/checklogin.php');
include('../partials/data send.php');
client();
include('../config/codeGen.php');

/* Add Reservations */

require_once("../partials/head.php");
?>

<body>

    <!-- Navigation Bar-->
    <?php
    require_once('../partials/client_nav.php');?>
    
    
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
                            <h4 class="page-title">Parking Lots</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Code Number</th>
                                        <th>Parking Lot Location</th>
                                        <th>Parking Slots</th>
                                        <th>Price Per Slot</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $ret = 'SELECT * FROM `parking_lots` ';
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($parking = $res->fetch_object()) { ?>
                                        <tr>
                                            <td><?php echo $parking->code; ?></td>
                                            <td><?php echo $parking->location; ?></td>
                                            <td><?php echo $parking->parking_slots; ?></td>
                                            <td>Ksh <?php echo $parking->price_per_slot; ?></td>
                                            <td>
                                            <a href="parkingSlot.php" class="badge bg-warning">Reserve Parking Slot</a>
                                            <!-- Update Modal -->
                                                
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container -->


            <!-- Footer -->
            
            <!-- End Footer -->


        </div>
        <!-- End wrapper -->
    <?php require_once("../partials/scripts.php");
     ?>

</body>

</html>