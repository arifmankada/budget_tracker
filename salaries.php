<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Salaries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

<h1 class="mt-4">Manage Salaries</h1>

<div class="card mb-4">
    <div class="card-body">
        <form method="post" action="salaries.php">
            <div class="mb-3">
                <label for="employee_name" class="form-label">Employee Name</label>
                <input type="text" name="employee_name" id="employee_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="salary_amount" class="form-label">Salary Amount</label>
                <input type="number" name="salary_amount" id="salary_amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="cash">Cash</option>
                    <option value="bank">Bank</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="payment_date" class="form-label">Payment Date</label>
                <input type="date" name="payment_date" id="payment_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <button type="submit" name="add_salary" class="btn btn-primary">Add Salary</button>
        </form>
    </div>
</div>

<?php
// Add Salary
if (isset($_POST['add_salary'])) {
    $employee_name = $_POST['employee_name'];
    $amount = $_POST['salary_amount'];
    $payment_method = $_POST['payment_method'];
    $payment_date = $_POST['payment_date'];
    $description = isset($_POST['description']) ? $_POST['description'] : ''; // Default to empty if not provided

    $query = "INSERT INTO salaries (employee_name, amount, payment_method, date, description) VALUES ('$employee_name', '$amount', '$payment_method', '$payment_date', '$description')";
    
    if (mysqli_query($conn, $query)) {
        echo '<div class="alert alert-success">Salary added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
    }
}
?>

</body>
</html>
