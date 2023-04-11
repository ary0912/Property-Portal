<?php
// Change these parameters according to your MySQL server setup
$servername = "localhost";
$username = "root";
$password = "bankai@5";
$dbname = "yourdatabasename";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the field parameter from a form or some other source
$field = "0";

// Prepare the SQL statement
$sql = "SELECT * FROM property WHERE approved = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameter to the placeholder
$stmt->bind_param("s", $field);

// Execute the statement
$stmt->execute();

// Get the results
$result = $stmt->get_result();

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Display the results in a table
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>UPRN</th><th>Property Details</th><th>Bank Loan</th><th>Loan Paper</th><th>Property Papers</th><th>Address</th><th>City</th><th>State</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["UPRN"] . "</td><td>" . $row["property_details"] . "</td><td>" . $row["bank_loan"] . "</td><td>" . $row["loan_paper"] . "</td><td>" . $row["property_paper"] . "</td><td>" . $row["address"] . "</td><td>" . $row["city"] . "</td><td>" . $row["state"] . "</td></tr>";
    }
    echo "</table>";
    header(Location: "sell_request.html");
} 
else {
    echo "No results found.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
