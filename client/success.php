<?php
session_start();
include('../config/config.php');
require_once('../config/checklogin.php');
client();
include_once('../partials/client_analytics.php');
require_once('../partials/head.php');

$id=$_GET['idd'];
echo $id;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Qr code</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
 
</head>

<body>
<?php require_once('../partials/client_nav.php'); ?>
    <div id="background-image">
        <div class="container_fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
</br></br></br></br>
                        <div class="card-body" style="text-align:center;"><br>
                            <p>Qr-code Generator</p><br><br>
                            <div><input id="t" type="text" placeholder="phonenumber" autofocus> </div><br>

                            <input id="demo" type="button" value="Generate Qr-code" class="btn btn-primary" onclick="generateQRCode();">
</br></br>
<p align="center">If you want to extend time then click on the extend below</p>
                            <a href="parkingSlot.php#reserve-id">Extend</a>
                            
                            <div><img id="lop" src="" /> </div><br>
                        

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../qrscript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<?php require_once("../partials/scripts.php"); ?>
</html>