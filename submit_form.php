<?php
header('Content-Type: application/json'); // Set response type to JSON

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $duration = htmlspecialchars($_POST['duration']);
    $safari_type = htmlspecialchars($_POST['safari_type']);
    $destinations = htmlspecialchars($_POST['destinations']);
    $group_size = htmlspecialchars($_POST['group_size']);
    $budget = htmlspecialchars($_POST['budget']);
    $special_requests = htmlspecialchars($_POST['special_requests']);
    $travel_dates = htmlspecialchars($_POST['travel_dates']);

    // Validate required fields
    if (empty($full_name) || empty($email) || empty($duration) || empty($safari_type) || empty($group_size) || empty($budget) || empty($travel_dates)) {
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
    $subject = "New Safari Customization Inquiry";
    $body = "
        <h2>New Safari Customization Inquiry</h2>
        <p><strong>Full Name:</strong> $full_name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> " . ($phone ? $phone : "Not provided") . "</p>
        <p><strong>Preferred Duration:</strong> $duration</p>
        <p><strong>Safari Type:</strong> $safari_type</p>
        <p><strong>Preferred Destinations:</strong> $destinations</p>
        <p><strong>Group Size:</strong> $group_size</p>
        <p><strong>Budget Range:</strong> $budget</p>
        <p><strong>Special Requests:</strong> $special_requests</p>
        <p><strong>Preferred Travel Dates:</strong> $travel_dates</p>
    ";

    // Email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Mafoya Africa Safaris <noreply@mafoyafricasafaris.com>" . "\r\n";
    $headers .= "Reply-To: $full_name <$email>" . "\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(['success' => true, 'message' => "Thank you, $full_name! Your safari inquiry has been sent."]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Oops! Something went wrong. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>