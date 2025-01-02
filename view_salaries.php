<?php
include 'db.php';
include 'header.php';

// Fetch all salary records from the database
$query = "SELECT * FROM salaries ORDER BY date DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-4">
    <h1>View Salaries</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Salary Amount</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['employee_name']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo isset($row['status']) ? $row['status'] : 'Not Set'; ?></td>
                        <td><?php echo $row['description']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No salary records found.</div>
    <?php endif; ?>
</div>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
