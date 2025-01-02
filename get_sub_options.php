<?php
include 'db.php';

if (isset($_POST['payment_method'])) {
    $payment_method = $_POST['payment_method'];

    if ($payment_method == 'Bank') {
        $query = "SELECT id, name FROM banks";
        $result = mysqli_query($conn, $query);
        echo "<label for='bank'>Select Bank</label>";
        echo "<select name='bank' id='bank' class='form-control'>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        echo "</select>";
    } elseif ($payment_method == 'UPI') {
        // Handle UPI specific options if needed
    } elseif ($payment_method == 'Credit Card') {
        // Handle Credit Card specific options if needed
    } else {
        echo ""; // No sub-options
    }
}
?>