<?php
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $limit_amount = $_POST['limit_amount'];
    $due_date = $_POST['due_date'];

    $sql = "INSERT INTO credit_cards (name, limit_amount, due_date) VALUES ('$name', '$limit_amount', '$due_date')";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Credit card added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<h1>Add Credit Card</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Card Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="limit_amount" class="form-label">Credit Limit</label>
        <input type="number" step="0.01" class="form-control" id="limit_amount" name="limit_amount" required>
    </div>
    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input type="date" class="form-control" id="due_date" name="due_date" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Card</button>
</form>

<?php include 'footer.php'; ?>
