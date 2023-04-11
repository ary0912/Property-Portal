<html>
    <body>
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

    // Get the form data submitted by the user
    $name = $_POST["name"];
    $email = $_POST["email"];
    $UPRN = $_POST["UPRN"];
    $selling_price = $_POST["selling_price"];
    $property_details = $_POST["property_details"];
    $bank_loan = $_POST["bank_loan"];
    $loan_paper = $_POST["loan_paper"];
    $property_papers = $_POST["property_papers"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $pincode = $_POST["pincode"];
    
    if ($bank_loan == "yes"){
        $bank_loan = 1;
    }
    else{
        $bank_loan = 0;
    }

    // Prepare and execute the SQL query to insert the form data into the database
    $stmt = $conn->prepare("INSERT INTO property (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $UPRN, $selling_price, $property_details, $bank_loan, $loan_paper, $property_papers, $address, $city, $state, $pincode);
    $stmt->execute();

    // Check if the form data was inserted successfully
    if ($stmt->affected_rows === 1) {
        header(Location: "application.html");
        exit();
    } 
    else {
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
?>
</body>
</html>