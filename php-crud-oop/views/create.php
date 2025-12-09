<?php
require_once '../controllers/StudentController.php';
$controller = new StudentController();

if ($_POST) {
    if($controller->create($_POST['name'], $_POST['email'])){
        header("Location: ../public/index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
    <link rel="stylesheet" href="../public/css/form-styles.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Add New Student</h1>
            <p>Fill in the details to add a new student</p>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="name">Student Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" placeholder="Enter student name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Student</button>
                <a href="../public/index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        
        <div class="back-link">
            <a href="../public/index.php">← Back to Student List</a>
        </div>
    </div>
</body>
</html>