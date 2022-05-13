<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.   
$url .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL   
$url .= $_SERVER['REQUEST_URI'];
date_default_timezone_set('Asia/Makassar');
$agent = $_SERVER["HTTP_USER_AGENT"];

if (preg_match('/MSIE (\d+\.\d+);/', $agent)) {
    $user_agent =  "Internet Explorer";
} else if (preg_match('/Chrome[\/\s](\d+\.\d+)/', $agent)) {
    $user_agent =  "Chrome";
} else if (preg_match('/Edge\/\d+/', $agent)) {
    $user_agent =  "Edge";
} else if (preg_match('/Firefox[\/\s](\d+\.\d+)/', $agent)) {
    $user_agent =  "Firefox";
} else if (preg_match('/OPR[\/\s](\d+\.\d+)/', $agent)) {
    $user_agent =  "Opera";
} else if (preg_match('/Safari[\/\s](\d+\.\d+)/', $agent)) {
    $user_agent =  "Safari";
}

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
}
//whether ip is from the proxy  
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
//whether ip is from the remote address  
else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
// User data to send using HTTP POST method in curl
$data = array('ip' => $ip,  'current_url' => $url, 'access_date' => date('Y-m-d H:i:s'),  'user_agent' => $user_agent);

// Data should be passed as json format
$data_json = json_encode($data);

// API URL to send data
$url = 'http://127.0.0.1:8000/api/store-log';

// curl initiate
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// SET Method as a POST
curl_setopt($ch, CURLOPT_POST, 1);

// Pass user data in POST command
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute curl and assign returned data
$response  = curl_exec($ch);

// Close curl
curl_close($ch);

// See response if data is posted successfully or any error
print_r($response);
