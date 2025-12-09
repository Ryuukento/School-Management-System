<?php
require_once '../controllers/EnrollmentController.php';
require_once '../controllers/StudentController.php';
require_once '../controllers/ProgramController.php';
require_once '../controllers/CourseController.php';

$controller = new EnrollmentController();
$studentController = new StudentController();
$programController = new ProgramController();
$courseController = new CourseController();

$students = $studentController->readAll();
$programs = $programController->readAll();
$courses = $courseController->readAll();

if ($_POST) {
    $controller->update($_POST['id'], $_POST['StudentID'], $_POST['ProgramID'], $_POST['CourseID'], $_POST['Grade'], $_POST['Semester'], $_POST['SchoolYear']);
    header("Location: ../public/index.php");
    exit;
}

$id = $_GET['id'];
$enrollments = $controller->readAll();
$current = null;

while($row = $enrollments->fetch(PDO::FETCH_ASSOC)) {
    if($row['id'] == $id) { $current = $row; break; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Enrollment</title>
    <link rel="stylesheet" href="../public/css/form-styles.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Edit Enrollment</h1>
            <p>Update enrollment information</p>
        </div>
        
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($current['id']) ?>">
            
            <div class="form-group">
                <label for="StudentID">Student <span class="required">*</span></label>
                <select id="StudentID" name="StudentID" required>
                    <option value="">Select a student</option>
                    <?php while($row = $students->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($row['id']) ?>" <?= $row['id'] == $current['StudentID'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['email']) ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="ProgramID">Program <span class="required">*</span></label>
                <select id="ProgramID" name="ProgramID" required>
                    <option value="">Select a program</option>
                    <?php while($row = $programs->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($row['id']) ?>" <?= $row['id'] == $current['ProgramID'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['ProgramName']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="CourseID">Course <span class="required">*</span></label>
                <select id="CourseID" name="CourseID" required>
                    <option value="">Select a course</option>
                    <?php while($row = $courses->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($row['id']) ?>" <?= $row['id'] == $current['CourseID'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['CourseName']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="Grade">Grade</label>
                <input type="text" id="Grade" name="Grade" value="<?= htmlspecialchars($current['Grade']) ?>">
            </div>
            
            <div class="form-group">
                <label for="Semester">Semester <span class="required">*</span></label>
                <select id="Semester" name="Semester" required>
                    <option value="">Select semester</option>
                    <option value="1st Semester" <?= $current['Semester'] == '1st Semester' ? 'selected' : '' ?>>1st Semester</option>
                    <option value="2nd Semester" <?= $current['Semester'] == '2nd Semester' ? 'selected' : '' ?>>2nd Semester</option>
                    <option value="Summer" <?= $current['Semester'] == 'Summer' ? 'selected' : '' ?>>Summer</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="SchoolYear">School Year <span class="required">*</span></label>
                <input type="text" id="SchoolYear" name="SchoolYear" value="<?= htmlspecialchars($current['SchoolYear']) ?>" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Enrollment</button>
                <a href="../public/index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        
        <div class="back-link">
            <a href="../public/index.php">← Back to Enrollment List</a>
        </div>
    </div>
</body>
</html>