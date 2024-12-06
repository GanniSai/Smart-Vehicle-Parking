<!-- HTML/PHP -->
<html>
<head>
    <!-- Your existing head content -->
    <style>
        #countdown {
            color: red;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="background-image">
        <div class="container_fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body" style="text-align:center;"><br>
                            <p> Time Remaining</p><br><br>
                            <div id="countdown"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
      $res = `SELECT * FROM payments WHERE client_phone='$PhoneNumber'`;
    // Assuming $endTime is a variable containing the end time from the server or user input
     // Replace this with your actual end time
    ?>

    <script>
        // JavaScript
        document.addEventListener("DOMContentLoaded", function () {
            // Assuming endTime is a variable containing the end time from the server or user input
            var endTime = <?php echo json_encode($endTime * 1000); ?>; // Convert to milliseconds

            function updateCountdown() {
                var now = new Date().getTime();
                var timeDifference = res - now;

                if (timeDifference > 0) {
                    var seconds = Math.floor((timeDifference / 1000) % 60);
                    var minutes = Math.floor((timeDifference / 1000 / 60) % 60);
                    var hours = Math.floor((timeDifference / (1000 * 60 * 60)) % 24);
                    var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

                    var countdownMessage = "Time remaining: " + days + " days, " + hours + " hours, " + minutes + " minutes, " + seconds + " seconds";

                    document.getElementById("countdown").textContent = countdownMessage;
                } else {
                    document.getElementById("countdown").textContent = "Time is up!";
                }
            }

            // Call updateCountdown initially
            updateCountdown();

            // Update the countdown every second
            setInterval(updateCountdown, 1000);
        });
    </script>
</body>
</html>





















                                                                                                                                                                                                                                                                                                            