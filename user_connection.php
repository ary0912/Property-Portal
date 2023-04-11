<?php
    // Change these parameters according to your MySQL server setup
    $servername = "localhost";
    $username = "root";
    $password = "bankai@5";
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
    $aadhar_no = $_POST["aadhar_no"];
    $pan_no = $_POST["pan_no"];

    // Prepare the SQL statement with placeholders
    $sql = "SELECT * FROM user WHERE user_id=?";
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the placeholders
    $stmt->bind_param("s", $user_id);

    // Execute the statement
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();

    // Check if a user with the same email address already exists
    if ($result->num_rows > 0) {
        echo "User with this email already exists";
    } 
    else {
        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO user (user_id, password, aadhar_no, pan_no) VALUES (?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters to the placeholders
        $stmt->bind_param("sss", $user_id, $password, $aadhar_no, $pan_no);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: user2.html");
            exit();
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
?>
