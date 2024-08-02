<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

require_once '../config/connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = trim($_POST['Username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_retype = $_POST['password_retype'];
    $admin_code = $_POST['admin_code'];

    // Validate form data
    if (empty($username) || empty($email) || empty($password) || empty($password_retype) || empty($admin_code)) {
        die("All fields are required.");
    }

    if ($password !== $password_retype) {
        die("Passwords do not match.");
    }

    // Check if the admin code is valid
    $stmt = mysqli_prepare($con, "SELECT id FROM admin_codes WHERE code = ?");
    mysqli_stmt_bind_param($stmt, 's', $admin_code);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        mysqli_stmt_close($stmt);
        die("Invalid admin code.");
    }
    mysqli_stmt_close($stmt);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user into the database
    $stmt = mysqli_prepare($con, "INSERT INTO Users (username, email, password, role) VALUES (?, ?, ?, 'admin')");
    if (!$stmt) {
        die("MySQL prepare statement failed: " . mysqli_error($con));
    }
    mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page in the view folder
        header("Location: ../view/login.html");
        exit();
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}

ob_end_flush();
?>
