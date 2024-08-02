<?php
require_once '../config/connection.php'; // Make sure this path is correct

$sql = "SELECT * FROM CropTypes"; // Correct table name
$result = mysqli_query($con, $sql);

if (!$result) {
    echo json_encode(['error' => 'Query failed: ' . mysqli_error($con)]);
    exit();
}

$crops = [];

while ($row = mysqli_fetch_assoc($result)) {
    $crops[] = $row;
}

echo json_encode($crops);

mysqli_close($con);
?>
