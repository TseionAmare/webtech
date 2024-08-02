<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $primary_system = $_POST['primary_system'];
    $primary_quantity = $_POST['primary_quantity'];
    $secondary_system = $_POST['secondary_system'];
    $secondary_quantity = $_POST['secondary_quantity'];
    $tertiary_system = $_POST['tertiary_system'];
    $tertiary_quantity = $_POST['tertiary_quantity'];

    try {
        // Begin transaction
        mysqli_begin_transaction($con);

        // Insert greenhouse
        $stmt = mysqli_prepare($con, "INSERT INTO Greenhouses (name, location) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, 'ss', $name, $location);
        mysqli_stmt_execute($stmt);
        $greenhouse_id = mysqli_insert_id($con);

        // Insert greenhouse systems
        $systems_data = [
            ['system_id' => $primary_system, 'quantity' => $primary_quantity],
            ['system_id' => $secondary_system, 'quantity' => $secondary_quantity],
            ['system_id' => $tertiary_system, 'quantity' => $tertiary_quantity]
        ];

        $stmt = mysqli_prepare($con, "INSERT INTO GreenhouseHydroponicSystems (greenhouse_id, system_id, quantity) VALUES (?, ?, ?)");
        foreach ($systems_data as $system) {
            if (!empty($system['system_id']) && !empty($system['quantity'])) {
                mysqli_stmt_bind_param($stmt, 'iii', $greenhouse_id, $system['system_id'], $system['quantity']);
                mysqli_stmt_execute($stmt);
            }
        }

        // Commit transaction
        mysqli_commit($con);

        // Redirect to index.html upon success
        header('Location: ../index.html');
        exit();
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        mysqli_rollback($con);

        // Handle the error (e.g., log it and show a user-friendly message)
        error_log($e->getMessage());

        // Redirect to 500.html upon failure
        header('Location: ../view/500.html');
        exit();
    }
}
?>
