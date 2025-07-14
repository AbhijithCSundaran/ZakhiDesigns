<?php
require_once 'vendor/autoload.php';
 
$client = new Google_Client(['client_id' => 'YOUR_GOOGLE_CLIENT_ID']); // verify token
$payload = $client->verifyIdToken($_POST['credential']);
 
if ($payload) {
    $google_id = $payload['sub'];
    $email = $payload['email'];
    $name = $payload['name'];
    $picture = $payload['picture'];
 
    // 🔒 Check if user exists in DB, otherwise insert
    // Example: login or register the user
    session_start();
    $_SESSION['user_id'] = $google_id;
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    $_SESSION['picture'] = $picture;
 
    // Redirect after login
    header('Location: /dashboard.php');
} else {
    echo "Invalid ID Token";
}