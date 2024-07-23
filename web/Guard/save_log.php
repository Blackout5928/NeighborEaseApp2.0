<?php
header('Content-Type: application/json');

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "neighborease";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(array('status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error)));
}

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);
$account_id = $data['account_id'];
$date = $data['date'];
$time = $data['time'];
$point = $data['point'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO access_point (account_id, date, time, point) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $account_id, $date, $time, $point);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(array('status' => 'success', 'message' => 'Log saved successfully.'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Failed to save log: ' . $stmt->error));
}

// Close the connection
$stmt->close();
$conn->close();
?>
