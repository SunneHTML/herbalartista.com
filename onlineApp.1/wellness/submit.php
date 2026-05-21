<?php
// submit.php

// CONFIGURATION
$recipient_email = "katprevas@yahoo.com"; // Your email
$csv_file = "vendor_submissions.csv";     // CSV file for records

// Get POST data and sanitize
$business = htmlspecialchars($_POST['business']);
$contact = htmlspecialchars($_POST['contact']);
$email = htmlspecialchars($_POST['email']);
$phone = htmlspecialchars($_POST['phone']);
$event_date = htmlspecialchars($_POST['event_date']);
$category = htmlspecialchars($_POST['category']);
$description = htmlspecialchars($_POST['description']);

// Validate required fields
if(empty($business) || empty($contact) || empty($email) || empty($event_date) || empty($category)) {
    die("Please fill in all required fields.");
}

// 1?? Email Notification
$subject = "New Vendor Submission: $business";
$message = "You have received a new vendor application for Back2Nature Wellness Market:\n\n";
$message .= "Business Name: $business\n";
$message .= "Contact: $contact\n";
$message .= "Email: $email\n";
$message .= "Phone: $phone\n";
$message .= "Event Date: $event_date\n";
$message .= "Category: $category\n";
$message .= "Description:\n$description\n";

$headers = "From: $email\r\n";
mail($recipient_email, $subject, $message, $headers);

// 2?? Append to CSV
if(!file_exists($csv_file)) {
    $header = ["Business","Contact","Email","Phone","Event Date","Category","Description"];
    $fp = fopen($csv_file, 'w');
    fputcsv($fp, $header);
} else {
    $fp = fopen($csv_file, 'a');
}

fputcsv($fp, [$business,$contact,$email,$phone,$event_date,$category,$description]);
fclose($fp);

// 3?? Redirect to a thank-you page
header("Location: thankyou.html");
exit;
?>