<?php
header('Content-Type: application/json'); // Set response type to JSON

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $tour_preference = htmlspecialchars($_POST['tour_preference']);
    $group_size = htmlspecialchars($_POST['group_size']);
    $message = htmlspecialchars($_POST['message']);
    $booking_date = htmlspecialchars($_POST['booking_date']);

    // Validate required fields
    if (empty($full_name) || empty($email) || empty($tour_preference) || empty($group_size) || empty($message) || empty($booking_date)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
        exit;
    }

    // Set up email
    $to = "info@mafoyafricasafaris.com"; // Your email address
    $subject = "New Safari Booking Inquiry";
    $body = "
        <h2>New Safari Booking Inquiry</h2>
        <p><strong>Full Name:</strong> $full_name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> " . ($phone ? $phone : "Not provided") . "</p>
        <p><strong>Preferred Safari Tour:</strong> $tour_preference</p>
        <p><strong>Group Size:</strong> $group_size</p>
        <p><strong>Message:</strong> $message</p>
        <p><strong>Preferred Booking Date:</strong> $booking_date</p>
    ";

    // Email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Mafoya Africa Safaris <noreply@mafoyafricasafaris.com>" . "\r\n";
    $headers .= "Reply-To: $full_name <$email>" . "\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(['success' => true, 'message' => "Thank you, $full_name! Your inquiry has been sent."]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Oops! Something went wrong. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>