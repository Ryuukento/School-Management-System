<?php
require_once '../controllers/ProgramController.php';

$controller = new ProgramController();

if ($_POST) {
    $controller->update($_POST['id'], $_POST['ProgramName'], $_POST['Description']);
    header("Location: ../public/index.php");
    exit;
}

$id = $_GET['id'];
$programs = $controller->readAll();
$current = null;

while($row = $programs->fetch(PDO::FETCH_ASSOC)) {
    if($row['id'] == $id) { $current = $row; break; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program</title>
    <link rel="stylesheet" href="../public/css/form-styles.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Edit Program</h1>
            <p>Update program information</p>
        </div>
        
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($current['id']) ?>">
            
            <div class="form-group">
                <label for="ProgramName">Program Name <span class="required">*</span></label>
                <input type="text" id="ProgramName" name="ProgramName" value="<?= htmlspecialchars($current['ProgramName']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="Description">Description <span class="required">*</span></label>
                <textarea id="Description" name="Description" required><?= htmlspecialchars($current['Description']) ?></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Program</button>
                <a href="../public/index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        
        <div class="back-link">
            <a href="../public/index.php">← Back to Program List</a>
        </div>
    </div>
</body>
</html>