<?php
include '../settings/connection.php';

// Access control: Only allow super admins
session_start();
if ($_SESSION['user_role'] !== 'super_admin') {
    header('Location: login.html');
    exit;
}

// Generate a new admin code
$admin_code = bin2hex(random_bytes(4)); // Generates a random 8-character code
$timestamp = date('Y-m-d H:i:s');

$sql = "INSERT INTO admin_codes (code, generated_at) VALUES (?, ?)";
$stmt = mysqli_prepare($con, $sql);

if (!$stmt) {
    die('Prepare failed: ' . mysqli_error($con));
}

mysqli_stmt_bind_param($stmt, 'ss', $admin_code, $timestamp);

if (mysqli_stmt_execute($stmt)) {
    echo "Admin code generated successfully: " . $admin_code;
} else {
    echo "Unable to generate admin code. Please try again later.";
    echo "Error: " . mysqli_error($con);
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
