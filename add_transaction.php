<?php
include 'db.php';

// Fetch payment methods
$payment_methods_query = "SELECT * FROM payment_methods";
$payment_methods_result = mysqli_query($conn, $payment_methods_query);

if (!$payment_methods_result) {
    die('<div class="alert alert-danger">Failed to fetch payment methods: ' . mysqli_error($conn) . '</div>');
}

// Fetch all banks
$banks_query = "SELECT * FROM bank_masters";
$banks_result = mysqli_query($conn, $banks_query);

if (!$banks_result) {
    die('<div class="alert alert-danger">Failed to fetch banks: ' . mysqli_error($conn) . '</div>');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-4">
    <h1>Add Transaction</h1>
    <div class="card mb-4">
        <div class="card-body">
            <form method="post" action="process_transaction.php">
                <!-- Transaction Type -->
                <div class="mb-3">
                    <label for="transaction_type" class="form-label">Transaction Type</label>
                    <select name="transaction_type" id="transaction_type" class="form-control" required>
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Select Category</option>
                    </select>
                </div>

                <!-- Payment Method -->
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="">Select Payment Method</option>
                        <?php
                        while ($method = mysqli_fetch_assoc($payment_methods_result)) {
                            echo "<option value='{$method['id']}'>{$method['name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Bank Dropdown (Initially Hidden) -->
                <div class="mb-3" id="bank_dropdown" style="display: none;">
                    <label for="bank" class="form-label">Select Bank</label>
                    <select name="bank" id="bank" class="form-control">
                        <option value="">Select Bank</option>
                        <?php
                        while ($bank = mysqli_fetch_assoc($banks_result)) {
                            echo "<option value='{$bank['id']}'>{$bank['name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Amount -->
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" name="amount" id="amount" class="form-control" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>

                <button type="submit" name="add_transaction" class="btn btn-primary">Add Transaction</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Show or hide bank dropdown based on payment method
    $('#payment_method').change(function() {
        const selectedMethod = $(this).val();
        if (selectedMethod.toLowerCase() === 'bank') {
            $('#bank_dropdown').show();
        } else {
            $('#bank_dropdown').hide();
        }
    });

    // Populate categories based on transaction type
    $('#transaction_type').change(function() {
        const transactionType = $(this).val();
        const categoryDropdown = $('#category');
        categoryDropdown.empty();
        categoryDropdown.append('<option value="">Loading...</option>');

        $.ajax({
            url: 'get_categories.php',
            type: 'POST',
            data: { type: transactionType },
            success: function(response) {
                categoryDropdown.empty();
                categoryDropdown.append('<option value="">Select Category</option>');
                const categories = JSON.parse(response);
                categories.forEach(category => {
                    categoryDropdown.append(`<option value="${category.id}">${category.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Failed to load categories. Please try again.');
            }
        });
    });

    // Ensure positive values for amount
    $('#amount').on('input', function() {
        if ($(this).val() < 0) {
            alert('Amount cannot be negative');
            $(this).val('');
        }
    });
});
</script>

</body>
</html>
