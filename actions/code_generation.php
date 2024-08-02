<?php
include 'secure_session_start.php'; // Custom function to start a secure session
include '../settings/connection.php';

if ($_SESSION['user_role'] !== 'super_admin') {
    header('Location: login.html');
    exit;
}

if (isset($_POST['generate'])) {
    $admin_code = bin2hex(random_bytes(8)); // More secure with longer bytes
    $timestamp = date('Y-m-d H:i:s');
    $expires = date('Y-m-d H:i:s', strtotime('+30 days')); // Code expires in 30 days

    $sql = "INSERT INTO admin_codes (code, generated_at, expires) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sss', $admin_code, $timestamp, $expires);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "Admin code generated successfully: " . $admin_code;
    } else {
        echo "Failed to generate code.";
    }
    $stmt->close();
}

$con->close();
?>
<!-- HTML form for generating code -->
<form method="post">
    <button type="submit" name="generate">Generate Admin Code</button>
</form>
