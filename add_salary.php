<?php
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $description = $_POST['description'];

    $sql = "INSERT INTO salaries (date, amount, payment_method, description) VALUES ('$date', '$amount', '$payment_method', '$description')";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Salary recorded successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<h1>Add Salary</h1>
<form method="POST">
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" name="date" required>
    </div>
    <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
    </div>
    <div class="mb-3">
        <label for="payment_method" class="form-label">Payment Method</label>
        <select class="form-control" id="payment_method" name="payment_method">
            <option value="cash">Cash</option>
            <option value="bank">Bank</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Add Salary</button>
</form>

<?php include 'footer.php'; ?>
