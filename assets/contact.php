<?php

// Only proceed with the PHP code if the form has been submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and sanitize the input data
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $phone = strip_tags(trim($_POST["phone"]));
    $message = trim($_POST["message"]);

    // Check that data was sent to the mailer.
    if ( empty($name) || empty($subject) || empty($phone) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Oops! There was a problem with your submission. Please complete the form and try again.";
        exit;
    }

    // Set the recipient email address.
    // FIXME: Update this to your desired email address.
    $recipient = "natetron990@gmail.com";

    // Set the email subject.
    $email_subject = "New contact from $name";

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "State: $subject\n"; // You mentioned 'State', assuming 'subject' is used as 'state' here
    $email_content .= "Phone: $phone\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers.
    $email_headers = "From: $name <$email>";

    // Send the email.
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}

?>
