<?php
// session_check.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if session variables are set
if (!isset($_SESSION['u_id']) || !isset($_SESSION['expire_time'])) {
    // Debugging output
    echo "Session variables not set. Redirecting to login.<br>";
    // Redirect to login if no session is found
    header("Location: ../login2.php");
    exit();
}

// Check if the session has expired
if (time() > $_SESSION['expire_time']) {
    // Debugging output
    echo "Session expired. Redirecting to login.<br>";
    // Session has expired, destroy it and redirect to login page
    session_unset();
    session_destroy();
    header("Location: ../login2.php?session_expired=1");
    exit();
}

// Refresh the session expire time on each request
$_SESSION['expire_time'] = time() + 3600; // 1 hour
?>
