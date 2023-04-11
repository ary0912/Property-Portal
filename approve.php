<?php

// Connect to the database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "property";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the row with the new value
$id = $_POST['id']; // the ID of the row to be updated
$new_value = "New Value"; // the new value to be set
$sql = "UPDATE property SET approved = 1 WHERE id = '$id'";
if ($conn->query($sql) === TRUE) {
    header(Location: "sell_request.html");
} 
else {
    echo "Error updating row: " . $conn->error;
}

// Close the database connection
$conn->close();

// Send an email to the user
$to = "user@example.com";
$subject = "Row updated";
$message = "The Application for selling the property has been approved";
$headers = "From: webmaster@example.com" . "\r\n" .
    "Reply-To: webmaster@example.com" . "\r\n" .
    "X-Mailer: PHP/" . phpversion();
mail($to, $subject, $message, $headers);

?>
