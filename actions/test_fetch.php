<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once '../config/connection.php';

try {
    // Fetch greenhouses and their systems
    $greenhouseStmt = $pdo->prepare("
        SELECT g.greenhouse_id, g.name, g.location, h.system_type, gh.quantity
        FROM Greenhouses g
        JOIN GreenhouseHydroponicSystems gh ON g.greenhouse_id = gh.greenhouse_id
        JOIN HydroponicSystems h ON gh.system_id = h.system_id
    ");
    $greenhouseStmt->execute();
    $greenhouses = $greenhouseStmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the fetched data
    echo "<pre>";
    print_r($greenhouses);
    echo "</pre>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
