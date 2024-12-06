<?php
session_start();
include('../config/config.php');
require_once('../config/checklogin.php');

client();
include('../config/codeGen.php');
/* Add Parking Slots */
if (isset($_POST['add_parkingslots'])) {
    // Error Handling and prevention of posting double entries
    $error = 0;

    // Validate and sanitize input
    $id = $_POST['id'];
    echo $id;
    $code = isset($_POST['code']) ? mysqli_real_escape_string($mysqli, trim($_POST['code'])) : '';
    $status = isset($_POST['status']) ? mysqli_real_escape_string($mysqli, trim($_POST['status'])) : '';

    // Check if required fields are not empty
    if (empty($id)) {
        $error = 1;
        $err = 'ID Cannot Be Empty';
    }

    if (empty($code)) {
        $error = 1;
        $err = 'Parking Slot Code Cannot Be Empty';
    }

    if (empty($status)) {
        $error = 1;
        $err = 'Status Cannot Be Empty';
    }

    if (!$error) {
        // Prevent Double entries
        $sql = "SELECT * FROM parkingslots WHERE code = '$code'";
        $res = mysqli_query($mysqli, $sql);

        if ($res && mysqli_num_rows($res) > 0) {
            $err =  "Parking Lot With That Code Already Exists ";
        } else {
            $query = 'INSERT INTO parkingslots (id, code, status) VALUES (?, ?, ?)';
            $stmt = $mysqli->prepare($query);

            // Check for successful preparation
            if ($stmt) {
                $status = ($status === null) ? '0' : $status;

                $rc = $stmt->bind_param('sss', $id, $code, $status);

                // Check for successful binding
                if ($rc) {
                    $stmt->execute();

                    // Check for successful execution
                    if ($stmt->affected_rows > 0) {
                        $success = 'Parking Lot Added' && header('refresh:1; url=parkingSlot.php');
                    } else {
                        $info = 'Please Try Again Or Try Later';
                    }
                } else {
                    $info = 'Error binding parameters';
                }

                // Close the statement
                $stmt->close();
            } else {
                $info = 'Error preparing statement';
            }
        }
    }
}





require_once("../partials/head.php");
?>

<body>

    <!-- Navigation Bar-->
    <?php require_once('../partials/admin_nav.php'); ?>
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

                    </div>
                </div>
            </div>
            <!-- Add Parking Lot Modal -->
            <div id="add_modal" class="modal-demo">
                <button type="button" class="close" onclick="Custombox.modal.close();">
                    <span>&times;</span><span class="sr-only">Close</span>
                </button>



                <h4 class="custom-modal-title">Fill All Required Fields</h4>
                <div class="custom-modal-text">
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <td><label for="id">ID:</label></td>
                                    <td>
                                        <input type="text" required name="id" value="<?php echo md5($ID) ?>" class="form-control">

                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="code">Parking Slot Code Number:</label></td>
                                    <td>
                                        <input type="text" required name="code" value="<?php echo $a . '-' . $b; ?>" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="status">Status:</label></td>
                                    <td>
                                        <?php
                                        if ($id == 1) {
                                            $s = "SELECT * FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                            $result = $mysqli->query($s);
                                            if ($result) {
                                                $res = $result->fetch_assoc()['field1'];
                                                $sid = $result->fetch_assoc()['id'];
                                                if ($res == 1) {
                                                    $status = "available";
                                                } else if (($res == 0)) {
                                                    $status = "booked";
                                                } else {
                                                    $status = "reserved";
                                                }
                                            } else {
                                                $status = "Error fetching data";
                                            }
                                            echo $id;
                                        }


                                        if ($id == 2) {
                                            $s = "SELECT field2 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                            $result = $mysqli->query($s);
                                            if ($result) {
                                                $res = $result->fetch_assoc()['field2'];
                                                if ($res == 1) {
                                                    $status = "available";
                                                } else if (($res == 0)) {
                                                    $status = "booked";
                                                } else {
                                                    $status = "reserved";
                                                }
                                            } else {
                                                $status = "Error fetching data";
                                            }
                                            echo $id;
                                        }

                                        // ... (similar changes for other conditions)
                                        if ($id == 3) {
                                            $s = "SELECT field3 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                            $result = $mysqli->query($s);
                                            if ($result) {
                                                $res = $result->fetch_assoc()['field3'];
                                                if ($res == 1) {
                                                    $status = "available";
                                                } else if (($res == 0)) {
                                                    $status = "booked";
                                                } else {
                                                    $status = "reserved";
                                                }
                                            } else {
                                                $status = "Error fetching data";
                                            }
                                            echo $id;
                                        }
                                        if ($id == 4) {
                                            $s = "SELECT field4 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                            $result = $mysqli->query($s);
                                            if ($result) {
                                                $res = $result->fetch_assoc()['field4'];
                                                if ($res == 1) {
                                                    $status = "available";
                                                } else if (($res == 0)) {
                                                    $status = "booked";
                                                } else {
                                                    $status = "reserved";
                                                }
                                            } else {
                                                $status = "Error fetching data";
                                            }
                                            echo $id;
                                        }
                                        ?>
                                        <input type="text" required name="status" value="<?php echo $status; ?>" class="form-control">

                                        <?php echo $sid; ?>

                                    </td>
                                </tr>
                            </table>

                            <div class="text-right">
                                <button type="submit" name="add_parkingslots" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>


            </div>
            <?php
            require_once('../partials/client_nav.php');
            /* 
        Load Logged In User Details Here To Avoid 
        Re entering them on reservations
     */
            $id  = $_SESSION['id'];
            $ret = "SELECT * FROM  clients  WHERE id = '$id'";
            $stmt = $mysqli->prepare($ret);
            $stmt->execute(); //ok
            $res = $stmt->get_result();
            while ($client = $res->fetch_object()) {
            ?>

                <!-- End Modal -->

                <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>code</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $ret = 'SELECT * FROM parkingslots';
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $stmt->bind_result($id, $code, $status); // Assuming you have these columns in your parkingslots table

                                    while ($stmt->fetch()) { ?>
                                        <tr>
                                            <td><?php echo $code; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td>

                                                <a href="#reserve-<?php if ($status == 'booked') {
                                                                        echo "disabled";
                                                                    } else {
                                                                        echo $id;
                                                                    } ?>" data-toggle="modal" class="badge bg-warning">Reserve Parking slot</a>
                                                <!-- Update Modal -->
                                                <div class="modal fade" id="reserve-<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <?php echo $id; ?>
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Reserve A Parking Slot On <?php echo $code; ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>


                                                            <div class="modal-body">
                                                                <form method="post" action="payments.php" enctype="multipart/form-data">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <!-- Hide This -->
                                                                            <?php echo $id; ?>
                                                                            <input type="text" required name="id" value="<?php echo $id; ?>" class="form-control">


                                                                            <input type="hidden" required name="status" value="Pending" class="form-control">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Client Name</label>
                                                                                <input type="text" required name="client_name" value="<?php echo $client->name; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Client Phone Number</label>
                                                                                <input type="text" required name="client_phone" value="<?php echo $client->phone; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Client Car Reg Number</label>
                                                                                <input type="text" required name="car_regno" class="form-control">
                                                                            </div>

                                                                            <div class="form-group col-md-4">
                                                                                <input type="hidden" required name="code" value="<?php echo $a; ?>-<?php echo $b; ?>" class="form-control">
                                                                            </div>

                                                                            <div class="form-group col-md-4">
                                                                                <input type="hidden" required name="lot_number" value="<?php echo $code; ?>" class="form-control">
                                                                            </div>


                                                                            <div class="form-group col-md-12">
                                                                                <label for="">Start Date And Time</label>
                                                                                <input type="datetime-local" value="<?php echo date('d M Y g:ia'); ?>" required name="parking_date" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <label for="">End Date And Time</label>
                                                                                <input type="datetime-local" required name="parking_end_date" class="form-control">
                                                                            </div>


                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="add_reservation" class="btn btn-primary">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer ">
                                                                <button type="button" class="pull-left btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
        <?php require_once("../partials/footer.php"); ?>
        <!-- End Footer -->

    </div>
    <!-- End wrapper -->
<?php require_once("../partials/scripts.php");
            } ?>

</body>

</html>

