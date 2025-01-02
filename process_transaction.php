<?php
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Safely retrieve and validate POST data
    $type = isset($_POST['type']) ? trim($_POST['type']) : null;
    $date = isset($_POST['date']) ? trim($_POST['date']) : null;
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0; // Ensure 'amount' is numeric
    $category = isset($_POST['category']) ? trim($_POST['category']) : null;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // Ensure required fields are not empty
    if (empty($type) || empty($date) || empty($amount) || empty($category)) {
        die('<div class="alert alert-danger">All fields are required!</div>');
    }

    // Validate the date format (optional but recommended)
    if (!DateTime::createFromFormat('Y-m-d', $date)) {
        die('<div class="alert alert-danger">Invalid date format. Use YYYY-MM-DD.</div>');
    }

    // Prepare the SQL query with placeholders
    $query = "INSERT INTO transactions (type, date, amount, category, description) 
              VALUES (?, ?, ?, ?, ?)";

    // Initialize the prepared statement
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind parameters to the query
        mysqli_stmt_bind_param($stmt, "ssdss", $type, $date, $amount, $category, $description);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            echo '<div class="alert alert-success">Transaction added successfully!</div>';
        } else {
            echo '<div class="alert alert-danger">Error executing the query: ' . htmlspecialchars(mysqli_error($conn)) . '</div>';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo '<div class="alert alert-danger">Error preparing the SQL statement: ' . htmlspecialchars(mysqli_error($conn)) . '</div>';
    }
}
?>
