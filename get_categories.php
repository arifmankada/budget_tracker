<?php
include 'db.php';

$type = isset($_GET['type']) ? trim($_GET['type']) : null;

if (!$type || !in_array($type, ['income', 'expense'])) {
    echo json_encode(['error' => 'Invalid transaction type']);
    exit;
}

$query = "SELECT * FROM category_masters WHERE type = ?";
if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_bind_param($stmt, "s", $type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    echo json_encode($categories);
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['error' => 'Database query failed']);
}

mysqli_close($conn);
?>
