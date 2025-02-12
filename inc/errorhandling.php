<?php 

function redirectToLoginWithError($errorMessage) {
    // URL encode the message to make it safe for use in a URL parameter
    $encodedMessage = urlencode($errorMessage);
    header("Location: ../../login.php?error=$encodedMessage");
    exit();
}

function update($errorMessage) {
    // URL encode the message to make it safe for use in a URL parameter
    // Detect the protocol (HTTP or HTTPS)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // Get the current URL
    $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Append the new parameter
    $newUrl = $currentUrl . "&message=" . $errorMessage;
    $encodedMessage = urlencode($errorMessage);
    header("Location: $newUrl");
    exit();
}

function category($category) {
    // URL encode the message to make it safe for use in a URL parameter
    $encodedMessage = urlencode($category);
    $current_url = $_SERVER['PHP_SELF'];
    $redirect_url = $current_url . "?category=$encodedMessage";
    header("Location: $redirect_url");
    exit();
}