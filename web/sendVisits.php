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
$houseNum = $_POST['houseNum'];
$message = $_POST['message'];
$contact = $_POST['contact_number'];
$add = $_POST['add'];
// Validate inputs
$errors = [];
if (strlen($name) < 4) {
    $errors[] = "Please enter at least 4 characters for your name.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
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

// Fetch homeowner details based on house number
$query = "SELECT username FROM home_owner WHERE hnum = ?";
$stmt = $CN->prepare($query);
$stmt->bind_param("s", $houseNum);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ownerName = $row['username']; // Assuming 'username' is the homeowner's name
} else {
    $errors[] = "No homeowner found with the provided house number.";
    echo json_encode(['status' => 'error', 'message' => $errors]);
    exit;
}

// Prepare and bind
$stmt = $CN->prepare("INSERT INTO visits (Guest_name, Guest_email, HO_name, HO_housenum, message, guest_contact, guest_add) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $email, $ownerName, $houseNum, $message, $contact, $add);

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
