<?php
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

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into Home_Owner table
    $sqlHomeOwner = "INSERT INTO Home_Owner (fname, lname, hnum, con_num, email, image, qr_code)
                     VALUES ('$fname', '$lname', '$houseNumber', '$contact', '$email', '$imagePath', '$qrCodePath')";

    if ($conn->query($sqlHomeOwner) === TRUE) {
        // Insert data into accounts table
        $sqlAccounts = "INSERT INTO accounts (Name, Contact_Number, Address, role, email, username, password)
                        VALUES ('$fname $lname', '$contact', '$houseNumber', 'owner', '$email', '$email', '$houseNumber')";

        if ($conn->query($sqlAccounts) === TRUE) {
            echo "Data saved successfully in both tables.";
        } else {
            echo "Error inserting into accounts table: " . $conn->error;
        }
    } else {
        echo "Error inserting into Home_Owner table: " . $conn->error;
    }

    // Close the connection
    $conn->close();

    // Redirect to another page
    header("Location: index.html");
    exit();
}

function saveImageFromBase64($base64Data, $fname, $lname) {
    $data = explode(',', $base64Data);
    $imageData = base64_decode($data[1]);
    $extension = 'png';

    $filename = strtolower($fname . '_' . $lname) . '.' . $extension;
    $filePath = 'uploads/' . $filename;
    file_put_contents($filePath, $imageData);
    return $filePath;
}

function saveQRCodeImage($qrCodeUrl, $fname, $lname) {
    $filename = strtolower($fname . '_' . $lname) . '.png';
    $filePath = 'qr_code/' . $filename;
    $qrCodeImage = file_get_contents($qrCodeUrl);
    file_put_contents($filePath, $qrCodeImage);

    return $filePath;
}

function sanitizeInput($conn, $input) {
    return $conn->real_escape_string($input);
}

function establishDatabaseConnection() {
    $conn = new mysqli("localhost", "root", "", "admin_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
