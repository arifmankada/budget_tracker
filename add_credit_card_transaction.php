<?php
include 'db.php';
include 'header.php';

$cards = $conn->query("SELECT * FROM credit_cards");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $card_id = $_POST['card_id'];
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];
    $description = $_POST['description'];

    $sql = "INSERT INTO credit_card_transactions (card_id, date, amount, type, description) 
            VALUES ('$card_id', '$date', '$amount', '$type', '$description')";
    if ($conn->query($sql)) {
        if ($type == 'expense') {
            $conn->query("UPDATE credit_cards SET outstanding_balance = outstanding_balance + $amount WHERE id = $card_id");
        } elseif ($type == 'payment') {
            $conn->query("UPDATE credit_cards SET outstanding_balance = outstanding_balance - $amount WHERE id = $card_id");
        }
        echo "<div class='alert alert-success'>Transaction recorded successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<h1>Add Credit Card Transaction</h1>
<form method="POST">
    <div class="mb-3">
        <label for="card_id" class="form-label">Credit Card</label>
        <select class="form-control" id="card_id" name="card_id" required>
            <?php while ($row = $cards->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?> (₹<?= $row['outstanding_balance'] ?>)</option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" name="date" required>
    </div>
    <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
    </div>
    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select class="form-control" id="type" name="type">
            <option value="payment">Payment</option>
            <option value="expense">Expense</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Add Transaction</button>
</form>

<?php include 'footer.php'; ?>
