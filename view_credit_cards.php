<?php
include 'db.php'; // Include database connection
include 'header.php'; // Include header (with dropdown menu)

$query = "SELECT * FROM credit_cards ORDER BY id DESC"; // Query to fetch credit card data
$result = mysqli_query($conn, $query); // Execute query
?>

<div class="container mt-4">
    <h1>View Credit Cards</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Card Name</th>
                    <th>Limit Amount</th>
                    <th>Outstanding Balance</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo number_format($row['limit_amount'], 2); ?></td>
                        <td><?php echo number_format($row['outstanding_balance'], 2); ?></td>
                        <td><?php echo $row['due_date']; ?></td>
                        <td>
                            <!-- Actions: Edit or Delete -->
                            <a href="edit_credit_card.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_credit_card.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this card?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No credit cards found.</div>
    <?php endif; ?>
</div>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
