<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming imageData is base64 encoded image data
    $imageData = $_POST['imageData'];  
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $contact = $_POST['contact'];
    $houseNumber = $_POST['hnum'];
    $email = $_POST['email'];

    // Generate QR code content
    $qrContent = "
        Guest Name: {$fname} {$lname} <br>
        Email: {$email} <br>
        Contact: {$contact} <br>
        House Number: {$houseNumber} <br>
    ";

    // Generate QR code URL using the external API
    $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($qrContent) . '&size=200x200';

    // Prepare data to return
    $response = [
        'qrCodeUrl' => $qrCodeUrl,
        'fname' => $fname,
        'lname' => $lname,
        'contact' => $contact,
        'hnum' => $houseNumber,
        'email' => $email
    ];

    // Return response as JSON
    echo json_encode($response);
    exit();
}
?>
