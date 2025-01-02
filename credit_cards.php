<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Credit Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

<h1 class="mt-4">Manage Credit Cards</h1>

<div class="card mb-4">
    <div class="card-body">
        <form method="post" action="credit_cards.php">
            <div class="mb-3">
                <label for="name" class="form-label">Card Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="limit_amount" class="form-label">Credit Limit</label>
                <input type="number" name="limit_amount" id="limit_amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="outstanding_balance" class="form-label">Outstanding Balance</label>
                <input type="number" name="outstanding_balance" id="outstanding_balance" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="form-control" required>
            </div>
            <button type="submit" name="add_card" class="btn btn-primary">Add Credit Card</button>
        </form>
    </div>
</div>

<?php
// Add Credit Card
if (isset($_POST['add_card'])) {
    $name = $_POST['name'];
    $limit_amount = $_POST['limit_amount'];
    $outstanding_balance = $_POST['outstanding_balance'];
    $due_date = $_POST['due_date'];

    $query = "INSERT INTO credit_cards (name, limit_amount, outstanding_balance, due_date) VALUES ('$name', '$limit_amount', '$outstanding_balance', '$due_date')";
    if (mysqli_query($conn, $query)) {
        echo '<div class="alert alert-success">Credit card added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
    }
}

// Display Credit Cards
$result = mysqli_query($conn, "SELECT * FROM credit_cards");
?>

<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>Card Name</th>
            <th>Credit Limit</th>
            <th>Outstanding Balance</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['limit_amount']); ?></td>
                <td><?php echo htmlspecialchars($row['outstanding_balance']); ?></td>
                <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                <td>
                    <a href="edit_credit_card.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_credit_card.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this card?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</div>
</body>
</html>
