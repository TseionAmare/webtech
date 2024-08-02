<?php
require_once '../config/connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $greenhouseId = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $systems = $_POST['systems']; // Array of systems

    // Update greenhouse details
    $updateGreenhouseQuery = "UPDATE Greenhouses SET name = ?, location = ? WHERE greenhouse_id = ?";
    $stmt = mysqli_prepare($con, $updateGreenhouseQuery);
    mysqli_stmt_bind_param($stmt, 'ssi', $name, $location, $greenhouseId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Delete existing systems for the greenhouse
    $deleteSystemsQuery = "DELETE FROM GreenhouseHydroponicSystems WHERE greenhouse_id = ?";
    $stmt = mysqli_prepare($con, $deleteSystemsQuery);
    mysqli_stmt_bind_param($stmt, 'i', $greenhouseId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Insert updated systems
    $insertSystemQuery = "INSERT INTO GreenhouseHydroponicSystems (greenhouse_id, system_id, quantity) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $insertSystemQuery);

    foreach ($systems as $system) {
        if (!empty($system['system_id']) && !empty($system['quantity'])) {
            mysqli_stmt_bind_param($stmt, 'iii', $greenhouseId, $system['system_id'], $system['quantity']);
            mysqli_stmt_execute($stmt);
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

    // Redirect to view_greenhouse.html after successful update
    header('Location: ../view/view_greenhouse.html');
    exit();
} else {
    echo "Invalid request.";
}
