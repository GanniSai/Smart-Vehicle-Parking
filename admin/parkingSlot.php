<?php
session_start();
include('../config/config.php');
require_once('../config/checklogin.php');

admin();
include('../config/codeGen.php');
/* Add Parking Slots */
if (isset($_POST['add_parkingslots'])) {
    // Error Handling and prevention of posting double entries
    $error = 0;

    // Validate and sanitize input
    $id = $_POST['id'];
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

/* Update Slots */
if (isset($_POST['update_parkingslots'])) {
    //Error Handling and prevention of posting double entries
    $error = 0;

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = 'ID Cannot Be Empty';
    }

    if (isset($_POST['code']) && !empty($_POST['code'])) {
        $code = mysqli_real_escape_string($mysqli, trim($_POST['code']));
    } else {
        $error = 1;
        $err = 'Parking Slot Code Cannot Be Empty';
    }

    if (isset($_POST['status']) && !empty($_POST['status'])) {
        $status = mysqli_real_escape_string($mysqli, trim($_POST['status']));
    } else {
        $error = 1;
        $err = 'status  Name Cannot Be Empty';
    }

    if (!$error) {

        $query = 'UPDATE parkingslots SET code =?, status=? WHERE id = ?';
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param(
            'sss',
            $code,
            $status,
            $id
        );

        $stmt->execute();
        if ($stmt) {
            $success =
                'Parking Lot Updated' && header('refresh:1; url=parkingSlot.php');
        } else {
            $info = 'Please Try Again Or Try Later';
        }
    }
}
/* Delete Slots */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $adn = 'DELETE FROM parkingslots WHERE id=?';
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = 'Deleted' && header('refresh:1; url=parkingSlot.php');
    } else {
        //inject alert that task failed
        $info = 'Please Try Again Or Try Later';
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
                        <div class="btn-group float-right m-t-15">
                            <a href="#add_modal" class="btn btn-primary waves-effect waves-light m-r-5 m-t-10" data-animation="door" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a">Add Parking slots</a>
                        </div>
                        <h4 class="page-title">Parking Slots</h4>
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
                                            $s = "SELECT field1 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                            $result = $mysqli->query($s);
                                            if ($result) {
                                                $res = $result->fetch_assoc()['field1'];
                                                
                                                if ($res == 1) {
                                                    $status = "available";
                                                } else if ($res == 0) {
                                                    $status = "booked";
                                                } else {
                                                    $status = "reserved";
                                                }
                                            } else {
                                                $status = "Error fetching data";
                                            }
                                            echo $res;
                                        }


                                        if ($id == 2) {
                                            $s = "SELECT field2 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                            $result = $mysqli->query($s);
                                            if ($result) {
                                                $res = $result->fetch_assoc()['field2'];
                                                if ($res == 1) {
                                                    $status = "available";
                                                } else if ($res == 0) {
                                                    $status = "booked";
                                                } else {
                                                    $status = "reserved";
                                                }
                                            } else {
                                                $status = "Error fetching data";
                                            }
                                            echo $res;
                                        }

                                        // ... (similar changes for other conditions)
                                        if ($id == 3) {
                                            $s = "SELECT field3 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                            $result = $mysqli->query($s);
                                            if ($result) {
                                                $res = $result->fetch_assoc()['field3'];
                                                if ($res == 1) {
                                                    $status = "available";
                                                } else if ($res == 0) {
                                                    $status = "booked";
                                                } else if ($res == 3) {
                                                    $status = "reserved";
                                                }
                                            } else {
                                                $status = "Error fetching data";
                                            }
                                            echo $status;
                                            echo $res;
                                            echo $id;
                                        }
                                        if ($id == 4) {
                                            $s = "SELECT field4 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                            $result = $mysqli->query($s);
                                            if ($result) {
                                                $res = $result->fetch_assoc()['field4'];
                                                if ($res == 1) {
                                                    $status = "available";
                                                } else if ($res == 0) {
                                                    $status = "booked";
                                                } else {
                                                    $status = "reserved";
                                                }
                                            } else {
                                                $status = "Error fetching data";
                                            }
                                            echo $status;
                                        }
                                        ?>
                                        <input type="text" required name="status" value="<?php echo $status; ?>" class="form-control">

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
                                            <a href="#update-<?php echo $id; ?>" data-toggle="modal" class="badge bg-warning">Update</a>
                                            <!-- Update Modal -->
                                            <div class="modal fade" id="update-<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update <?php echo $code; ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" enctype="multipart/form-data">
                                                                <div class="card-body">
                                                                    <div class="row">

                                                                        <table class="table">
                                                                            <tr>
                                                                                <td><label for="id">ID:</label></td>
                                                                                <td>
                                                                                    <input type="text" required name="id" value="<?php echo $id; ?>" class="form-control">
                                                                                    
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
                                                                                        $s = "SELECT field1 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                                                                        $result = $mysqli->query($s);
                                                                                        if ($result) {
                                                                                            $res = $result->fetch_assoc()['field1'];
                                                                                            if ($res == 1) {
                                                                                                $status = "available";
                                                                                            } else if ($res == 0) {
                                                                                                $status = "booked";
                                                                                            } else {
                                                                                                $status = "reserved";
                                                                                            }
                                                                                        } else {
                                                                                            $status = "Error fetching data";
                                                                                        }
                                                                                        
                                                                                    } elseif ($id == 2) {
                                                                                        $s = "SELECT field2 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                                                                        $result = $mysqli->query($s);
                                                                                        if ($result) {
                                                                                            $res = $result->fetch_assoc()['field2'];
                                                                                            if ($res == 1) {
                                                                                                $status = "available";
                                                                                            } else if ($res == 0) {
                                                                                                $status = "booked";
                                                                                            } else {
                                                                                                $status = "reserved";
                                                                                            }
                                                                                        } else {
                                                                                            $status = "Error fetching data";
                                                                                        }
                                                                                        echo $status;
                                                                                        // ... (similar changes for other conditions)
                                                                                    }


                                                                                    if ($id == 3) {
                                                                                        $s = "SELECT field3 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                                                                        $result = $mysqli->query($s);
                                                                                        if ($result) {
                                                                                            $res = $result->fetch_assoc()['field3'];
                                                                                            if ($res == 3) {
                                                                                                $status = "reserved";
                                                                                            } else if ($res == 0) {
                                                                                                $status = "booked";
                                                                                            } else if($res==1) {
                                                                                                $status = "available";
                                                                                            }
                                                                                        } else {
                                                                                            $status = "Error fetching data";
                                                                                        }
                                                                                        echo $status;
                                                                                    }
                                                                                    if ($id == 4) {
                                                                                        $s = "SELECT field4 FROM thingspeakdata ORDER BY timestamp DESC LIMIT 1";
                                                                                        $result = $mysqli->query($s);
                                                                                        if ($result) {
                                                                                            $res = $result->fetch_assoc()['field1'];
                                                                                            if ($res == 1) {
                                                                                                $status = "available";
                                                                                            } else if ($res == 0) {
                                                                                                $status = "booked";
                                                                                            } else {
                                                                                                $status = "reserved";
                                                                                            }
                                                                                        } else {
                                                                                            $status = "Error fetching data";
                                                                                        }
                                                                                        echo $status;
                                                                                    }
                                                                                    //echo $res;

                                                                                    ?>
                                                                                    <input type="text" required name="status" value="<?php echo $status; ?>" class="form-control">
                                                                                    <?php echo $status ?>

                                                                                    <?php echo $res;
                                                                                    echo $id; ?>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_parkingslots" class="btn btn-primary">Submit</button>
                                                                        </div>
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

                                            <a href="#delete-<?php echo $id; ?>" class="badge bg-danger" data-animation="makeway" data-plugin="custommodal" data-overlaySpeed="100">Delete</a>
                                            <!-- Delete Modal -->
                                            <div id="delete-<?php echo $id; ?>" class="modal-demo">
                                                <button type="button" class="close" onclick="Custombox.modal.close();">
                                                    <span>&times;</span><span class="sr-only">Close</span>
                                                </button>
                                                <h4 class="custom-modal-title">Confirm Deletion</h4>
                                                <div class="text-center">
                                                    <h4>Delete <?php echo $code; ?> ? </h4>
                                                    <br>
                                                    <button type="button" class="text-center btn btn-success" onclick="Custombox.modal.close();">No</button>
                                                    <a href="parkingSlot.php?delete=<?php echo $id; ?>" class="text-center btn btn-danger"> Delete </a>
                                                </div>
                                            </div>

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
    <?php require_once("../partials/scripts.php"); ?>

</body>

</html>