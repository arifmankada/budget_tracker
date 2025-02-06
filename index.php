<?php
include 'db.php';
include 'header.php';

// Fetch totals
$totalIncome = $conn->query("SELECT SUM(amount) AS total FROM transactions WHERE type='income'")->fetch_assoc()['total'] ?? 0;
$totalExpense = $conn->query("SELECT SUM(amount) AS total FROM transactions WHERE type='expense'")->fetch_assoc()['total'] ?? 0;
$balance = $totalIncome - $totalExpense;

// Fetch recent transactions
$recent = $conn->query("SELECT * FROM transactions ORDER BY date DESC LIMIT 5");
?>

<h1>Budget Tracker2</h1>
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Income</h5>
                <p class="card-text">₹<?= number_format($totalIncome, 2) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Expense</h5>
                <p class="card-text">₹<?= number_format($totalExpense, 2) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Balance</h5>
                <p class="card-text">₹<?= number_format($balance, 2) ?></p>
            </div>
        </div>
    </div>
</div>

<h2>Recent Transactions</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Category</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $recent->fetch_assoc()): ?>
            <tr>
                <td><?= $row['date'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= ucfirst($row['type']) ?></td>
                <td>₹<?= number_format($row['amount'], 2) ?></td>
                <td><?= $row['description'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
