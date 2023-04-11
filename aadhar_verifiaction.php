<?php
    $uid = "123412341234"; // Replace with the Aadhaar card number to verify
    $txnId = rand(100000000000, 999999999999); // Generate a random transaction ID
    $publicCertPath = "/path/to/public/cert.pem"; // Replace with the path to your public certificate file
    $privateCertPath = "/path/to/private/cert.p12"; // Replace with the path to your private certificate file
    $privateCertPassword = "your_private_cert_password"; // Replace with your private certificate password

    // Set the API endpoint URL
    $url = "https://auth.uidai.gov.in/1.6/public/16/$uid/$txnId";

    // Set the request headers
    $headers = [
        "Content-Type: application/xml",
        "Accept: application/xml",
        "X-Forwarded-For: 127.0.0.1",
    ];

    // Load the public certificate
    $publicCert = file_get_contents($publicCertPath);

    // Load the private certificate
    $privateCert = file_get_contents($privateCertPath);

    // Create the XML request
    $xml = <<<XML
    <?xml version="1.0" encoding="UTF-8"?>
    <Auth xmlns="http://www.uidai.gov.in/authentication/uid-auth-request/1.0" uid="$uid" txnId="$txnId">
        <Uses otp="n" biometric="n" pin="n"/>
        <Meta fdc="NC" idc="NA" lot="P" lov="560103" pip="127.0.0.1"/>
        <Skey ci="12345678901234567890123456789012">$publicCert</Skey>
        <Data type="X">$uid</Data>
        <Hmac>$privateCertPassword</Hmac>
    </Auth>
    XML;

    // Create the cURL request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSLCERT, $publicCertPath);
    curl_setopt($ch, CURLOPT_SSLKEY, $privateCertPath);
    curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $privateCertPassword);

    // Send the request and get the response
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        echo "Error: " . curl_error($ch);
    } 
    else {
        // Parse the XML response
        $xml = simplexml_load_string($response);
        $code = (string) $xml->AuthRes->Ret;
        if ($code == "Y") {
            echo "Aadhaar card number is verified";
        } 
        else {
            echo "Aadhaar card number verification failed";
        }
    }

    // Close the cURL request
    curl_close($ch);
?>