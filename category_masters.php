<?php
include 'db.php';
include 'header.php';

// Handle Add or Edit Category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $category_name = $_POST['category_name'];
        $type = $_POST['type'];

        $query = "INSERT INTO category_masters (name, type) VALUES ('$category_name', '$type')";
        if (mysqli_query($conn, $query)) {
            echo '<div class="alert alert-success">Category added successfully!</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
        }
    } elseif (isset($_POST['edit_category'])) {
        $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];
        $type = $_POST['type'];

        $query = "UPDATE category_masters SET name = '$category_name', type = '$type' WHERE id = '$category_id'";
        if (mysqli_query($conn, $query)) {
            echo '<div class="alert alert-success">Category updated successfully!</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
        }
    }
}

// Handle Delete Category
if (isset($_GET['delete'])) {
    $category_id = $_GET['delete'];
    $query = "DELETE FROM category_masters WHERE id = '$category_id'";
    if (mysqli_query($conn, $query)) {
        echo '<div class="alert alert-success">Category deleted successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<h1 class="mt-4">Category Masters</h1>

<!-- Add/Edit Category Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="post" action="category_masters.php">
            <input type="hidden" name="category_id" id="category_id" value="">
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" name="category_name" id="category_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>
            <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
            <button type="submit" name="edit_category" class="btn btn-success d-none" id="edit_button">Update Category</button>
        </form>
    </div>
</div>

<!-- Display Categories -->
<h3>Existing Categories</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM category_masters");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['type']}</td>
                <td>
                    <button class='btn btn-sm btn-info edit-category' 
                        data-id='{$row['id']}' 
                        data-name='{$row['name']}' 
                        data-type='{$row['type']}'>Edit</button>
                    <a href='category_masters.php?delete={$row['id']}' class='btn btn-sm btn-danger'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </tbody>
</table>

<script>
    // Handle Edit Button Click
    document.querySelectorAll('.edit-category').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('category_id').value = button.getAttribute('data-id');
            document.getElementById('category_name').value = button.getAttribute('data-name');
            document.getElementById('type').value = button.getAttribute('data-type');
            document.getElementById('edit_button').classList.remove('d-none');
            document.querySelector('button[name="add_category"]').classList.add('d-none');
        });
    });
</script>
