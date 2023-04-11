<?php
    $pan = "ABCDE1234F"; // Replace with the PAN card number to verify
    $url = "https://incometaxindiaefiling.gov.in/e-FilingWS/dit/secured/validatePan.do?panNumber=$pan"; // Set the API endpoint URL

    // Set the request headers
    $headers = [
        "Content-Type: application/json",
        "Accept: application/json",
    ];

    // Create the cURL request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Send the request and get the response
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        echo "Error: " . curl_error($ch);
    } 
    else {
        // Parse the JSON response
        $json = json_decode($response, true);
        if ($json["isValid"] == "Y") {
            echo "PAN card number is verified";
        } 
        else {
            echo "PAN card number verification failed";
        }
    }

    // Close the cURL request
    curl_close($ch);
?>
