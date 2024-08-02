<?php
require_once '../config/connection.php'; // Ensure this path is correct

// Prepare the SQL statement
$sql = "SELECT g.greenhouse_id, g.name, g.location, hs.system_type, gh.quantity
        FROM Greenhouses g
        LEFT JOIN GreenhouseHydroponicSystems gh ON g.greenhouse_id = gh.greenhouse_id
        LEFT JOIN HydroponicSystems hs ON gh.system_id = hs.system_id";

$result = mysqli_query($con, $sql);

if (!$result) {
    echo json_encode(['error' => 'Query failed: ' . mysqli_error($con)]);
    exit();
}

$greenhouses = [];

while ($row = mysqli_fetch_assoc($result)) {
    $greenhouses[] = $row;
}

echo json_encode($greenhouses);

mysqli_close($con);
?>
