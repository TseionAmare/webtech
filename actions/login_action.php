<?php
include '../config/connection.php'; // Make sure the path is correct

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        die("MySQL prepare statement failed: " . mysqli_error($con));
    }
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Password is correct, start the session
            $_SESSION['user_id'] = $user['user_id']; // Use correct column name
            $_SESSION['user_role'] = $user['role'];  // Use correct column name
            $_SESSION['user_email'] = $user['email'];

            // Redirect to appropriate dashboard based on user role
            if ($user['role'] == 'admin') { // Ensure role matches the database values
                header("Location: /Farmitecture/index.html"); // Adjust path as needed
            } else {
                header("Location: /Farmitecture/view/login_user.html"); // Adjust path as needed
            }
            exit();
        } else {
            echo '<script>
                alert("Incorrect password.");
                window.location.href = "../view/login.html";
                </script>';
        }
    } else {
        echo '<script>
            alert("No user found with this email.");
            window.location.href = "../view/login.html";
            </script>';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    echo "Form not submitted.";
}
?>

