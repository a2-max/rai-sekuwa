<?php
header('Content-Type: application/json');

// Sanitize input
$firstName = isset($_POST['firstname']) ? htmlspecialchars(trim($_POST['firstname'])) : '';
$lastName = isset($_POST['lastname']) ? htmlspecialchars(trim($_POST['lastname'])) : '';
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
$phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
$message = isset($_POST['message']) ? nl2br(htmlspecialchars(trim($_POST['message']))) : '';

if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

$fullName = $firstName . ' ' . $lastName;

// Email settings
$to = 'neupanerijan6@gmail.com';
$subject = 'New Contact Form Submission - Rai Sekuwa Corner';
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: Rai Sekuwa Corner <info@raisekuwacorner.com.au>" . "\r\n";

// HTML email template
$body = "
<html>
<head>
  <title>New Contact Form Submission</title>
  <style>
    body { font-family: Arial, sans-serif; line-height: 1.6; }
    .label { font-weight: bold; }
  </style>
</head>
<body>
  <h2>New Contact Message</h2>
  <p><span class='label'>Name:</span> {$fullName}</p>
  <p><span class='label'>Email:</span> {$email}</p>
  <p><span class='label'>Phone:</span> {$phone}</p>
  <p><span class='label'>Message:</span><br>{$message}</p>
</body>
</html>
";

// Send the email
$sent = mail($to, $subject, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send message. Please try again later.']);
}
