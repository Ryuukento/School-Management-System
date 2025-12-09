<?php
require_once '../controllers/StudentController.php';

$controller = new StudentController();

if ($_POST) {
    $controller->update($_POST['id'], $_POST['name'], $_POST['email']);
    header("Location: ../public/index.php");
    exit;
}

$id = $_GET['id'];
$students = $controller->readAll();
$current = null;

while($row = $students->fetch(PDO::FETCH_ASSOC)) {
    if($row['id'] == $id) { $current = $row; break; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="../public/css/form-styles.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Edit Student</h1>
            <p>Update student information</p>
        </div>
        
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($current['id']) ?>">
            
            <div class="form-group">
                <label for="name">Student Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($current['name']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($current['email']) ?>" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Student</button>
                <a href="../public/index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        
        <div class="back-link">
            <a href="../public/index.php">← Back to Student List</a>
        </div>
    </div>
</body>
</html>