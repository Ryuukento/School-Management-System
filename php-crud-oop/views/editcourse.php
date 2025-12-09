<?php
require_once '../controllers/CourseController.php';
require_once '../controllers/ProgramController.php';

$controller = new CourseController();
$programController = new ProgramController();
$programs = $programController->readAll();

if ($_POST) {
    $controller->update($_POST['id'], $_POST['CourseName'], $_POST['Units'], $_POST['program_id']);
    header("Location: ../public/index.php");
    exit;
}

$id = $_GET['id'];
$courses = $controller->readAll();
$current = null;

while($row = $courses->fetch(PDO::FETCH_ASSOC)) {
    if($row['id'] == $id) { $current = $row; break; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link rel="stylesheet" href="../public/css/form-styles.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Edit Course</h1>
            <p>Update course information</p>
        </div>
        
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($current['id']) ?>">
            
            <div class="form-group">
                <label for="CourseName">Course Name <span class="required">*</span></label>
                <input type="text" id="CourseName" name="CourseName" value="<?= htmlspecialchars($current['CourseName']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="Units">Units <span class="required">*</span></label>
                <input type="number" id="Units" name="Units" value="<?= htmlspecialchars($current['Units']) ?>" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="program_id">Program <span class="required">*</span></label>
                <select id="program_id" name="program_id" required>
                    <option value="">Select a program</option>
                    <?php while($row = $programs->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($row['id']) ?>" <?= $row['id'] == $current['program_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['ProgramName']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Course</button>
                <a href="../public/index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        
        <div class="back-link">
            <a href="../public/index.php">← Back to Course List</a>
        </div>
    </div>
</body>
</html>