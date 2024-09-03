<?php
$con = mysqli_connect('localhost', 'root', '', 'admin_db');

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

$q = $_REQUEST["q"];

$esp8266_ip = "192.168.73.20"; // Define the IP address here

if ($q != "") {
    $trimmed_q = $q;

    $stmt = $con->prepare("SELECT * FROM logs WHERE account_id = ?");
    $stmt->bind_param("s", $trimmed_q);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $stmt = $con->prepare("INSERT INTO logs (account_id, date, time, point) VALUES (?, CURDATE(), CURTIME(), ?)");
        $point = "In";
        $stmt->bind_param("ss", $trimmed_q, $point);
        if ($stmt->execute()) {
            echo '<div class="alert alert-success"><strong>Success!</strong> Home Owner Entered</div>' . date('l jS \of F Y h:i:s A');
            $url = "http://$esp8266_ip/open-servo";
            file_get_contents($url);

            // Send account_id to ESP8266 to display on LCD
            $display_url = "http://$esp8266_ip/display?message=" . urlencode($trimmed_q);
            $display_response = file_get_contents($display_url);
            if ($display_response === FALSE) {
                echo '<div class="alert alert-warning"><strong>Warning!</strong> Could not send display message</div>';
            }
        } else {
            echo '<div class="alert alert-danger"><strong>Error!</strong> Fail</div>';
        }
    } else {
        echo '<div class="alert alert-success"><strong>Success!</strong> Home Owner already Entered</div>' . date('l jS \of F Y h:i:s A');

        // Send account_id to ESP8266 to display on LCD
        $display_url = "http://$esp8266_ip/display?message=" . urlencode($trimmed_q);
        $display_response = file_get_contents($display_url);
        if ($display_response === FALSE) {
            echo '<div class="alert alert-warning"><strong>Warning!</strong> Could not send display message</div>';
        }
    } 
    $stmt->close();
}

mysqli_close($con);
?>
