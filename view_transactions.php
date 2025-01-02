<?php
include 'db.php';
include 'header.php';
?>

<div class="container mt-4">
    <h1>View Transactions</h1>

    <!-- Display all transactions in a table -->
    <?php
    $query = "SELECT * FROM transactions ORDER BY date DESC"; // Use 'date' instead of 'transaction_date'
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-bordered">';
        echo '<thead><tr>';
        echo '<th>Transaction ID</th>';
        echo '<th>Amount</th>';
        echo '<th>Category</th>';
        echo '<th>Type</th>';
        echo '<th>Date</th>';
        echo '<th>Description</th>';
        echo '<th>Action</th>';
        echo '</tr></thead><tbody>';
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . number_format($row['amount'], 2) . '</td>';
            echo '<td>' . $row['category'] . '</td>';
            echo '<td>' . ucfirst($row['type']) . '</td>';
            echo '<td>' . $row['date'] . '</td>'; // Correct column name
            echo '<td>' . $row['description'] . '</td>';
            echo '<td><a href="edit_transaction.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a></td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<div class="alert alert-warning">No transactions found.</div>';
    }
    ?>
</div>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
