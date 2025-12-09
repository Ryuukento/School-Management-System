<?php
require_once '../controllers/CourseController.php';
require_once '../controllers/ProgramController.php';

$controller = new CourseController();
$programController = new ProgramController();
$programs = $programController->readAll();

if ($_POST) {
    if($controller->create($_POST['CourseName'], $_POST['Units'], $_POST['program_id'])){
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
    <title>Add New Course</title>
    <link rel="stylesheet" href="../public/css/form-styles.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Add New Course</h1>
            <p>Fill in the details to add a new course</p>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="CourseName">Course Name <span class="required">*</span></label>
                <input type="text" id="CourseName" name="CourseName" placeholder="Enter course name" required>
            </div>
            
            <div class="form-group">
                <label for="Units">Units <span class="required">*</span></label>
                <input type="number" id="Units" name="Units" placeholder="Enter number of units" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="program_id">Program <span class="required">*</span></label>
                <select id="program_id" name="program_id" required>
                    <option value="">Select a program</option>
                    <?php while($row = $programs->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['ProgramName']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Course</button>
                <a href="../public/index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        
        <div class="back-link">
            <a href="../public/index.php">← Back to Course List</a>
        </div>
    </div>
</body>
</html>