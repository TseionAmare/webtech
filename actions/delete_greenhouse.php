<?php
require_once '../config/connection.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $greenhouseId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($greenhouseId <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid ID']);
        exit();
    }

    $stmt = mysqli_prepare($con, "DELETE FROM Greenhouses WHERE greenhouse_id = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Prepare statement failed: ' . mysqli_error($con)]);
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'i', $greenhouseId);
    $executeResult = mysqli_stmt_execute($stmt);

    if ($executeResult) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete: ' . mysqli_stmt_error($stmt)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

mysqli_close($con);
?>
