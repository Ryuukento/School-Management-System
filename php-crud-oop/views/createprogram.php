<?php
require_once '../controllers/ProgramController.php';
$controller = new ProgramController();

if ($_POST) {
    if($controller->create($_POST['ProgramName'], $_POST['Description'])){
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
    <title>Add New Program</title>
    <link rel="stylesheet" href="../public/css/form-styles.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Add New Program</h1>
            <p>Fill in the details to add a new program</p>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="ProgramName">Program Name <span class="required">*</span></label>
                <input type="text" id="ProgramName" name="ProgramName" placeholder="Enter program name" required>
            </div>
            
            <div class="form-group">
                <label for="Description">Description <span class="required">*</span></label>
                <textarea id="Description" name="Description" placeholder="Enter program description" required></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Program</button>
                <a href="../public/index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        
        <div class="back-link">
            <a href="../public/index.php">← Back to Program List</a>
        </div>
    </div>
</body>
</html>