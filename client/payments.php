<?php
session_start();
include('../config/config.php');
require_once('../config/checklogin.php');
client();
include('../config/codeGen.php');


require_once("../partials/head.php");



$amt = 0;

if (isset($_POST['add_reservation'])) {
    //Error Handling and prevention of posting double entries
    $error = 0;


    $id = $_POST['id'];



    $code = $_POST['code'];



    $client_name = $_POST['client_name'];



    $client_phone = $_POST['client_phone'];



    $car_regno = $_POST['car_regno'];



    $lot_number = $_POST['lot_number'];


    $parking_date = $_POST['parking_date'];



    $parking_end_date = $_POST['parking_end_date'];

$idd=$_POST['id'];


    // ... (previous code)
    // Assuming $parking_date and $parking_end_date are strings representing dates
    $parking_date = new DateTime($parking_date);
    $parking_end_date = new DateTime($parking_end_date);

    $interval = $parking_date->diff($parking_end_date);
    $totalDays = (int)$interval->format('%days');
    // Get the total number of minutes as an integer
    $totalMinutes = (int)$interval->format('%i');

    // Get the total number of hours and remaining minutes
    $totalHours = (int)$interval->format('%h');
    $remainingMinutes = $totalMinutes % 60;

    $totalMinutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
    if ($totalMinutes <= 60) {

        $amt = 40;
    } else {
        $amt = $totalMinutes * 1;
    }


    // Now convert DateTime objects to strings for SQL
    $parking_date_str = $parking_date->format('Y-m-d H:i:s');
    $parking_end_date_str = $parking_end_date->format('Y-m-d H:i:s');



    if (!$error) {
        //prevent Double entries
        $sql = "SELECT * FROM  reservations WHERE  code='$code' ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($code = $row['code'])
             {
                $err =  "Client Parking Reservation With That Code Number Already Exists ";
            } else {
            }
        } else {

            $query = 'INSERT INTO reservations (code, client_name, client_phone, car_regno, lot_number, parking_date,parking_end_date, amt) VALUES(?,?,?,?,?,?,?,?)';
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param(
                'ssssssss',  // 11 placeholders
                $code,
                $client_name,
                $client_phone,
                $car_regno,
                $lot_number,
                $parking_date_str,
                $parking_end_date_str,
                $amt
            );

            $stmt->execute();

            if ($stmt) {

            
            } else {
                $info = 'Please Try Again Or Try Later';
            }
        }
       
    }
}

// Initialize variables
$client_phone = isset($_POST['client_phone']) ? $_POST['client_phone'] : '';
$client_name = isset($_POST['client_name']) ? $_POST['client_name'] : '';

$code = isset($_POST['code']) ? $_POST['code'] : '';

require_once("../partials/head.php");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <!-- Add your styles or link to a stylesheet here -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 110vh;
        }

        #paymentForm {
            background-color: #fff;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 200px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 4px;
            margin-bottom: 2px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <?php require_once('../partials/client_nav.php');
    $parking_date=" ";
    $parking_end_date=" ";
    ?>
<?php echo $_POST['car_regno']; ?>
    <form method="post">
        <div class="card-body">
            <h3 align="center">PAYMENT</h3></br>
            <div class="row">
                <!-- Hide This -->
                <input type="text" required name="id" value="<?php echo $idd; ?>" class="form-control">

                <div class="form-group col-md-6">
                    <label for="">Client Phone Number</label>
                    <input type="text" value="<?php echo $_POST['client_phone']; ?>" required name="client_phone" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Client Name</label>
                    <input type="text" value="<?php echo $_POST['client_name']; ?>" name="client_name" required class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="">car regno</label>
                    <input type="text" value="<?php echo $car_regno; ?>" required name="car_regno" class="form-control">
                </div>
                <img src="../payimg.jpg" class="img-fluid img-cover" alt="payment" style="width: 100px; height: 100px; border: 2px solid #ccc; border-radius: 10px;"> />
                
                <div class="form-group col-md-6">
                    <label for="">Parking Fee</label>
                    <input type="text" value="<?php echo $amt; ?>" required name="amt" class="form-control">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="">Payment Code</label>
                    <input type="text" required value="<?php echo $code; ?>" name="code" class="form-control">
                </div>
            </div>
            <div class="text-right">
                <button type="submit" name="update_payments" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</body>

<?php
if (isset($_POST['update_payments'])) 
{
    $connection = mysqli_connect("localhost", "root", "", "parkinglotsreservations");
    if ($connection) 
    {
        
        $id = $_POST['id']; 
        $code = $_POST['code'];
       $amt= $_POST['amt'];
        $client_name = $_POST['client_name'];
        $client_phone = $_POST['client_phone'];
        $car_regno = $_POST['car_regno'];
        
      




        $sql="insert into payments values('$id','$code','$amt','$client_name','$client_phone','$car_regno')";

        $query_runner=mysqli_query($connection,$sql);

      

        


        echo "<script>alert('payment successfull');
        
        window.location.href='success.php';
        </script>";


    }

     
}

require_once("../partials/scripts.php");
?>
</body>

</html>