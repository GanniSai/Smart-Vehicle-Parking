function generateQRCode() {
    var phoneNumber = document.getElementById("t").value;

    if (phoneNumber === "") {
        alert("Please enter a phone number");
        return false;
    } else {
        // Construct the URL with a parameterized query
        var url = `../server_script.php?phone=${encodeURIComponent(phoneNumber)}`;

        // Make an asynchronous request to the server-side script
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Process the retrieved data
                console.log(JSON.stringify(data));

                if (data.error) {
                    alert(data.error);
                } else {
                    // Set the generated QR code as the source of the image
                    document.getElementById("lop").setAttribute("src", `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(JSON.stringify(data))}`);

                    
                    //alert(JSON.stringify(data));
                }
            })
            .catch(error => console.error('Error:', error));
    }

    document.getElementById('kio').style.backgroundColor = 'green';
}
    
/*function displayTime() {
    var phoneNumber = document.getElementById("phoneNumber").value;

    if (phoneNumber === "") {
        alert("Please enter a phone number");
        return false;
    } else {
        var url = `../extend.php?phone=${encodeURIComponent(phoneNumber)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    var startTime = new Date(data.data.parking_date);
                    var endTime = new Date(data.data.parking_end_date);
//alert('${startTime}');
//alert('${endTime}');
                    var remainingTime = endTime - startTime;

                    var minutes = Math.floor(remainingTime / (1000 * 60));
                    var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                    alert(`Remaining Time: ${minutes} minutes ${seconds} seconds`);

                    if (minutes <= 10) {
                        setTimeout(function () {
                            var extend = confirm("Reservation ending in 10 minutes. Do you want to extend?");
                            if (extend) {
                                // Handle the extend logic here or redirect to another page
                                alert("Reservation extended!");
                            }
                        }, remainingTime - 10 * 60 * 1000);
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }
}*/