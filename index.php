<?php

// Check if this file is being directly accessed
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    include 'inc/header.php';
}

// Get the requested URL
$request_uri = $_SERVER['REQUEST_URI'];

// Remove query string
$request_uri = strtok($request_uri, '?');

// Remove leading/trailing slashes and .php extension
$request_uri = trim($request_uri, '/');
$request_uri = preg_replace('/\.php$/', '', $request_uri);

// If the requested URI is empty, it means the user is accessing the root URL
if ($request_uri === '') {
    include 'home.php'; // Change 'index.php' to your default file if needed
    exit();
}

// Construct the path to the PHP file
$file_path = __DIR__ . '/' . $request_uri . '.php';

// Check if the file exists and is readable
if (file_exists($file_path) && is_readable($file_path)) {
    include $file_path;
} else {
    // If the file doesn't exist, return a 404 error
    http_response_code(404);
    echo '404 Not Found';
}

// Check if this file is being directly accessed
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    include 'inc/footer.php';
}

