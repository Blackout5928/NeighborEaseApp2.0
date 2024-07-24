<?php
// Establish database connection
$conn = establishDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $fname = sanitizeInput($conn, $_POST['fname']);
    $lname = sanitizeInput($conn, $_POST['lname']);
    $contact = sanitizeInput($conn, $_POST['contact']);
    $houseNumber = sanitizeInput($conn, $_POST['hnum']);
    $email = sanitizeInput($conn, $_POST['email']);
    $imageData = $_POST['imageData'];
    $imagePath = saveImageFromBase64($imageData, $fname, $lname);

    // Generate QR code
    $qrContent = "House Number: {$houseNumber} \nGuest Name: {$fname} {$lname} \nEmail: {$email} \nContact: {$contact}";
    $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($qrContent) . '&size=200x200';
    $qrCodePath = saveQRCodeImage($qrCodeUrl, $fname, $lname);
        // Prepare and bind sample_login statement
        $username = $fname . $lname;
        $password = $houseNumber;
    // Prepare and bind Home_Owner statement
    $stmtHomeOwner = $conn->prepare("INSERT INTO Home_Owner (username, fname, lname, hnum, con_num, email, image, qr_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtHomeOwner->bind_param("ssssisss", $username, $fname, $lname, $houseNumber, $contact, $email, $imagePath, $qrCodePath);

    // Execute Home_Owner statement
    if ($stmtHomeOwner->execute()) {

        $stmtAccounts = $conn->prepare("INSERT INTO sampel_login ( email, username, password) VALUES (?, ?, ?)");
        $fullName = "$fname $lname";
        $stmtAccounts->bind_param("sss", $email, $username, $password);

        // Execute sample_login statement
        if ($stmtAccounts->execute()) {
            echo "Data saved successfully in both tables.";
        } else {
            echo "Error inserting into accounts table: " . $stmtAccounts->error;
        }
    } else {
        echo "Error inserting into Home_Owner table: " . $stmtHomeOwner->error;
    }

    // Close the statements and connection
    $stmtHomeOwner->close();
    $stmtAccounts->close();
    $conn->close();

    // Redirect to another page
    header("Location: index.html");
    exit();
}

// Function to save base64 encoded image
function saveImageFromBase64($base64Data, $fname, $lname) {
    $data = explode(',', $base64Data);
    $imageData = base64_decode($data[1]);
    $extension = 'png'; // Assuming the image format is PNG

    $filename = strtolower($fname . '_' . $lname) . '.' . $extension;
    $filePath = 'uploads/' . $filename;
    file_put_contents($filePath, $imageData);
    return $filePath;
}

// Function to save QR code image
function saveQRCodeImage($qrCodeUrl, $fname, $lname) {
    $filename = strtolower($fname . '_' . $lname) . '.png';
    $filePath = 'qr_code/' . $filename;
    $qrCodeImage = file_get_contents($qrCodeUrl);
    file_put_contents($filePath, $qrCodeImage);

    return $filePath;
}

// Function to sanitize input
function sanitizeInput($conn, $input) {
    return $conn->real_escape_string(trim($input));
}

// Function to establish database connection
function establishDatabaseConnection() {
    $conn = new mysqli("localhost", "root", "", "admin_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
