<?php
// create a new cURL resource
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://writemypaperforme.org/send-emails");
curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);
?>