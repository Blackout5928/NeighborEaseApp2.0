<?php
// Connect to the database
$CN = mysqli_connect("localhost", "root", "");
$DB = mysqli_select_db($CN, "admin_db");

// Check connection
if ($CN->connect_error) {
    die("Connection failed: " . $CN->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$ownerName = $_POST['ownerName'];
$houseNum = $_POST['houseNum'];
$message = $_POST['message'];

// Validate inputs
$errors = [];
if (strlen($name) < 4) {
    $errors[] = "Please enter at least 4 characters for your name.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}
if (strlen($ownerName) < 4) {
    $errors[] = "Please enter at least 4 characters for the homeowner's name.";
}
if (strlen($houseNum) < 1) {
    $errors[] = "Please enter at least 1 character for the house number.";
}
if (empty($message)) {
    $errors[] = "Please write something for the message.";
}

// Check for errors
if (count($errors) > 0) {
    echo json_encode(['status' => 'error', 'message' => $errors]);
    exit;
}

// Prepare and bind
$stmt = $CN->prepare("INSERT INTO visits (Guest_name, Guest_email, HO_name, HO_housenum, message) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $ownerName, $houseNum, $message);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Your message has been sent. Thank you!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'There was an error saving your message.']);
}

// Close the statement and connection
$stmt->close();
$CN->close();
?>
