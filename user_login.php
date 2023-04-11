<?php
    // Change these parameters according to your MySQL server setup
    $servername = "localhost";
    $username = "yourusername";
    $password = "yourpassword";
    $dbname = "property_exchange";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the user details from a form or some other source
    $user_id = $_POST["user_id"];
    $password = $_POST["password"];

    // Prepare the SQL statement with placeholders
    $sql = "SELECT * FROM users WHERE user_id=? AND password=?";
    $stmt = $conn->prepare($sql);

    // Hash the password for security
    $hashed_password = hash("sha256", $password);

    // Bind the parameters to the placeholders
    $stmt->bind_param("ss", $user_id, $hashed_password);

    // Execute the statement
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();

    // Check if a user with the given email and password exists
    if ($result->num_rows === 1) {
        // User is authenticated, redirect to the dashboard or some other page
        header("Location: propertyexchange.html");
        exit();
    } 
    else {
        // User authentication failed, show an error message
        echo "Invalid email or password";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
?>
