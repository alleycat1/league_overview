<?php
// Get the country code from the request, or default to 'World'
$country = isset($_GET['country_code']) ? $_GET['country_code'] : 'World';

// Handle the case when the country is 'World'
if ($country === 'World') {
    $country = '';  // or whatever value is needed to fetch 'World' leagues
}

// API endpoint and headers
$apiUrl = 'https://api-football-v1.p.rapidapi.com/v3/leagues?country=' . urlencode($country);
$headers = [
    'x-rapidapi-host: api-football-v1.p.rapidapi.com',
    'x-rapidapi-key: 07a47debc9msh0d44d31dc75f408p1723a7jsnf20bfa454be9'  // replace with your RapidAPI key
];

// Initialize a cURL session
$ch = curl_init();

// Set the options for the cURL session
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Execute the cURL session and fetch the data
$response = curl_exec($ch);

// Close the cURL session
curl_close($ch);

// Output the response
echo $response;
?>

