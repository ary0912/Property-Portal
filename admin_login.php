<?php
    // Replace with your database connection details
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "property_exchange";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the username and password submitted by the form
    $admin_id = $_POST["admin_id"];
    $password = $_POST["password"];

    // Prepare and execute the SQL query to verify the login credentials
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE admin_id=? AND password=?");
    $stmt->bind_param("ss", $admin_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the login credentials were verified
    if ($result->num_rows === 1) {
        // Login successful, redirect to the admin dashboard
        header("Location: admincon.html");
    } 
    else {
        // Login failed, show error message
        echo "Invalid username or password";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
?>
