<?php
include 'db.php';
include 'header.php';

// Fetch the transaction data based on the provided ID
$id = $_GET['id'];
$query = "SELECT * FROM transactions WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$transaction = mysqli_fetch_assoc($result);

// Fetch categories for the dropdown
$categories_query = "SELECT * FROM categories";
$categories_result = mysqli_query($conn, $categories_query);

// Update the transaction if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_transaction'])) {
    $amount = $_POST['amount'];
    $category = $_POST['category']; // Selected category
    $type = $_POST['type'];
    $description = $_POST['description'];
    $transaction_date = $_POST['transaction_date'];

    // Update the transaction in the database
    $update_query = "UPDATE transactions SET amount = '$amount', category = '$category', type = '$type', 
                     date = '$transaction_date', description = '$description' WHERE id = '$id'";

    if (mysqli_query($conn, $update_query)) {
        echo '<div class="alert alert-success">Transaction updated successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<h1 class="mt-4">Edit Transaction</h1>

<!-- Edit Transaction Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="post" action="edit_transaction.php?id=<?php echo $id; ?>">
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" value="<?php echo $transaction['amount']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php
                    // Display categories in the dropdown and mark the selected category
                    while ($row = mysqli_fetch_assoc($categories_result)) {
                        $selected = ($row['name'] == $transaction['category']) ? 'selected' : '';
                        echo "<option value='{$row['name']}' {$selected}>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="income" <?php echo ($transaction['type'] == 'income') ? 'selected' : ''; ?>>Income</option>
                    <option value="expense" <?php echo ($transaction['type'] == 'expense') ? 'selected' : ''; ?>>Expense</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="transaction_date" class="form-label">Transaction Date</label>
                <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="<?php echo $transaction['date']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control"><?php echo $transaction['description']; ?></textarea>
            </div>

            <button type="submit" name="update_transaction" class="btn btn-primary">Update Transaction</button>
        </form>
    </div>
</div>
