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
    if($controller->create($_POST['StudentID'], $_POST['ProgramID'], $_POST['CourseID'], $_POST['Grade'], $_POST['Semester'], $_POST['SchoolYear'])){
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
    <title>Add New Enrollment</title>
    <link rel="stylesheet" href="../public/css/form-styles.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Add New Enrollment</h1>
            <p>Fill in the details to enroll a student</p>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="StudentID">Student <span class="required">*</span></label>
                <select id="StudentID" name="StudentID" required>
                    <option value="">Select a student</option>
                    <?php while($row = $students->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['email']) ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="ProgramID">Program <span class="required">*</span></label>
                <select id="ProgramID" name="ProgramID" required>
                    <option value="">Select a program</option>
                    <?php while($row = $programs->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['ProgramName']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="CourseID">Course <span class="required">*</span></label>
                <select id="CourseID" name="CourseID" required>
                    <option value="">Select a course</option>
                    <?php while($row = $courses->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['CourseName']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="Grade">Grade</label>
                <input type="text" id="Grade" name="Grade" placeholder="Enter grade ">
            </div>
            
            <div class="form-group">
                <label for="Semester">Semester <span class="required">*</span></label>
                <select id="Semester" name="Semester" required>
                    <option value="">Select semester</option>
                    <option value="1st Semester">1st Semester</option>
                    <option value="2nd Semester">2nd Semester</option>
                    <option value="Summer">Summer</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="SchoolYear">School Year <span class="required">*</span></label>
                <input type="text" id="SchoolYear" name="SchoolYear" placeholder="Enter school year (e.g., 2024-2025)" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Enrollment</button>
                <a href="../public/index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        
        <div class="back-link">
            <a href="../public/index.php">← Back to Enrollment List</a>
        </div>
    </div>
</body>
</html>