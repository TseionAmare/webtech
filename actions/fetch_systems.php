<?php
require_once '../config/connection.php'; // Ensure this path is correct

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Prepare the SQL query
    $sql = "SELECT * FROM HydroponicSystems";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        echo json_encode(['error' => 'Query failed: ' . mysqli_error($con)]);
        exit();
    }

    $systems = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (empty($systems)) {
        echo json_encode(['error' => 'No systems found']);
    } else {
        echo json_encode($systems);
    }

    // Free the result and close the connection
    mysqli_free_result($result);
    mysqli_close($con);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch systems: ' . $e->getMessage()]);
}
?>
