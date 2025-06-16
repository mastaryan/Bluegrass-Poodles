<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: index.html?status=error&message=All fields are required.");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.html?status=error&message=Invalid email format.");
        exit;
    }

    // Email settings
    $to = "puppies@bluegrassdoodle.com";
    $subject = "Stud Service Request from $name";
    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n";
    $headers = "From: noreply@bluegrassdoodle.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        header("Location: index.html?status=success");
    } else {
        header("Location: index.html?status=error&message=Failed to send message. Please try again later.");
    }
} else {
    header("Location: index.html?status=error&message=Invalid request method.");
}
exit;
?>