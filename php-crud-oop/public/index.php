<?php
require_once '../controllers/StudentController.php';
require_once '../controllers/CourseController.php';
require_once '../controllers/ProgramController.php';
require_once '../controllers/EnrollmentController.php';

$studentController = new StudentController();
$courseController = new CourseController();
$programController = new ProgramController();
$enrollmentController = new EnrollmentController();

// Determine the current page (default to 'students')
$currentPage = isset($_GET['page']) ? strtolower($_GET['page']) : 'students';
if (!in_array($currentPage, ['students', 'enrollments', 'programs', 'courses'])) {
    $currentPage = 'students';
}

if (isset($_GET['delete']) && isset($_GET['type'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        switch($_GET['type']) {
            case 'student':
                $studentController->delete($id);
                break;
            case 'course':
                $courseController->delete($id);
                break;
            case 'program':
                $programController->delete($id);
                break;
            case 'enrollment':
                $enrollmentController->delete($id);
                break;
        }
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/filters.js"></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>School Enrollment System</h1>
            <p>Manage Students, Programs, Courses and Enrollments</p>
        </div>
        
        <div class="nav-buttons">
            <a href="students" class="nav-link <?php echo ($currentPage === 'students') ? 'active' : ''; ?>">Students</a>
            <a href="enrollments" class="nav-link <?php echo ($currentPage === 'enrollments') ? 'active' : ''; ?>">Enrollments</a>
            <a href="programs" class="nav-link <?php echo ($currentPage === 'programs') ? 'active' : ''; ?>">Programs</a>
            <a href="courses" class="nav-link <?php echo ($currentPage === 'courses') ? 'active' : ''; ?>">Courses</a>
        </div>
        <!-- Hidden image used to extract a dominant/average color for the page background.
             Place your image at `public/img/palette.jpg` (or change the src below).
        -->
        <img id="palette-source" src="img/palette.jpg" alt="palette" style="display:none;width:1px;height:1px;" crossorigin="anonymous">
        
        <div class="content">
            <!-- STUDENTS SECTION -->
            <?php if ($currentPage === 'students'): ?>
            <div class="section active" id="students">
                <div class="section-header">
                    <h2>Students</h2>
                    <a href="../views/create.php" class="btn btn-success">+ Add New Student</a>
                </div>
                <div class="filter-container">
                    <label>Search:</label>
                    <input type="text" id="studentFilter" class="filter-input" placeholder="Search students..." onkeyup="filterTable('studentTable', 'studentFilter', [1,2])">
                    <button class="btn-clear" onclick="clearFilter('studentTable', 'studentFilter')">Clear</button>
                </div>
                <table id="studentTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $students = $studentController->readAll();
                        while($row = $students->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><span class="badge badge-primary">#<?= $row['id'] ?></span></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td>
                                <div class="action-links">
                                    <a href="../views/edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                                    <a href="?page=students&delete=<?= $row['id'] ?>&type=student" class="btn-delete" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <!-- ENROLLMENTS SECTION -->
            <?php if ($currentPage === 'enrollments'): ?>
            <div class="section active" id="enrollments">
                <div class="section-header">
                    <h2>Enrollments</h2>
                    <a href="../views/createenrollment.php" class="btn btn-success">+ Add New Enrollment</a>
                </div>
                <div class="filter-container">
                    <label>Search:</label>
                    <input type="text" id="enrollmentFilter" class="filter-input" placeholder="Search enrollments..." onkeyup="filterTable('enrollmentTable', 'enrollmentFilter', [1,2,3,4,5,6])">
                    
                    <label>Grade:</label>
                    <select id="gradeFilter" class="filter-select" onchange="filterBySelect('enrollmentTable', 'gradeFilter', 4)">
                        <option value="">All Grades</option>
                        <?php 
                        $enrollments_temp = $enrollmentController->readAll();
                        $grades = [];
                        while($row = $enrollments_temp->fetch(PDO::FETCH_ASSOC)) {
                            if (!in_array($row['Grade'], $grades)) {
                                $grades[] = $row['Grade'];
                            }
                        }
                        sort($grades);
                        foreach($grades as $grade): ?>
                            <option value="<?= htmlspecialchars($grade) ?>"><?= htmlspecialchars($grade) ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <label>Semester:</label>
                    <select id="semesterFilter" class="filter-select" onchange="filterBySelect('enrollmentTable', 'semesterFilter', 5)">
                        <option value="">All Semesters</option>
                        <?php 
                        $enrollments_temp2 = $enrollmentController->readAll();
                        $semesters = [];
                        while($row = $enrollments_temp2->fetch(PDO::FETCH_ASSOC)) {
                            if (!in_array($row['Semester'], $semesters)) {
                                $semesters[] = $row['Semester'];
                            }
                        }
                        sort($semesters);
                        foreach($semesters as $semester): ?>
                            <option value="<?= htmlspecialchars($semester) ?>"><?= htmlspecialchars($semester) ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <label>School Year:</label>
                    <select id="schoolYearFilter" class="filter-select" onchange="filterBySelect('enrollmentTable', 'schoolYearFilter', 6)">
                        <option value="">All Years</option>
                        <?php 
                        $enrollments_temp3 = $enrollmentController->readAll();
                        $years = [];
                        while($row = $enrollments_temp3->fetch(PDO::FETCH_ASSOC)) {
                            if (!in_array($row['SchoolYear'], $years)) {
                                $years[] = $row['SchoolYear'];
                            }
                        }
                        sort($years);
                        foreach($years as $year): ?>
                            <option value="<?= htmlspecialchars($year) ?>"><?= htmlspecialchars($year) ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <button class="btn-clear" onclick="clearFilter('enrollmentTable', 'enrollmentFilter', ['gradeFilter', 'semesterFilter', 'schoolYearFilter'])">Clear All</button>
                </div>
                <table id="enrollmentTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student ID</th>
                            <th>Program ID</th>
                            <th>Course ID</th>
                            <th>Grade</th>
                            <th>Semester</th>
                            <th>School Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $enrollments = $enrollmentController->readAll();
                        while($row = $enrollments->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><span class="badge badge-primary">#<?= $row['id'] ?></span></td>
                            <td><?= htmlspecialchars($row['StudentID']) ?></td>
                            <td><?= htmlspecialchars($row['ProgramID']) ?></td>
                            <td><?= htmlspecialchars($row['CourseID']) ?></td>
                            <td><?= htmlspecialchars($row['Grade']) ?></td>
                            <td><?= htmlspecialchars($row['Semester']) ?></td>
                            <td><?= htmlspecialchars($row['SchoolYear']) ?></td>
                            <td>
                                <div class="action-links">
                                    <a href="../views/editenrollment.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                                    <a href="?page=enrollments&delete=<?= $row['id'] ?>&type=enrollment" class="btn-delete" onclick="return confirm('Are you sure you want to delete this enrollment?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <!-- PROGRAMS SECTION -->
            <?php if ($currentPage === 'programs'): ?>
            <div class="section active" id="programs">
                <div class="section-header">
                    <h2>Programs</h2>
                    <a href="../views/createprogram.php" class="btn btn-success">+ Add New Program</a>
                </div>
                <div class="filter-container">
                    <label>Search:</label>
                    <input type="text" id="programFilter" class="filter-input" placeholder="Search programs..." onkeyup="filterTable('programTable', 'programFilter', [1,2])">
                    <button class="btn-clear" onclick="clearFilter('programTable', 'programFilter')">Clear</button>
                </div>
                <table id="programTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Program Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $program = $programController->readAll();
                        while($row = $program->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><span class="badge badge-success">#<?= $row['id'] ?></span></td>
                            <td><?= htmlspecialchars($row['ProgramName']) ?></td>
                            <td><?= htmlspecialchars($row['Description']) ?></td>
                            <td>
                                <div class="action-links">
                                    <a href="../views/editprogram.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                                    <a href="?page=programs&delete=<?= $row['id'] ?>&type=program" class="btn-delete" onclick="return confirm('Are you sure you want to delete this program?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <!-- COURSES SECTION -->
            <?php if ($currentPage === 'courses'): ?>
            <div class="section active" id="courses">
                <div class="section-header">
                    <h2>Courses</h2>
                    <a href="../views/createcourse.php" class="btn btn-success">+ Add New Course</a>
                </div>
                <div class="filter-container">
                    <label>Search:</label>
                    <input type="text" id="courseFilter" class="filter-input" placeholder="Search courses..." onkeyup="filterTable('courseTable', 'courseFilter', [1,2,3])">
                    <button class="btn-clear" onclick="clearFilter('courseTable', 'courseFilter')">Clear</button>
                </div>
                <table id="courseTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course Name</th>
                            <th>Units</th>
                            <th>Program ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $courses = $courseController->readAll();
                        while($row = $courses->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><span class="badge badge-info">#<?= $row['id'] ?></span></td>
                            <td><?= htmlspecialchars($row['CourseName']) ?></td>
                            <td><?= htmlspecialchars($row['Units']) ?> units</td>
                            <td><?= htmlspecialchars($row['program_id']) ?></td>
                            <td>
                                <div class="action-links">
                                    <a href="../views/editcourse.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                                    <a href="?page=courses&delete=<?= $row['id'] ?>&type=course" class="btn-delete" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function applyAverageColorFromImage(imgId, cssVarName = '--page-color', sampleStep = 10) {
            const img = document.getElementById(imgId);
            if (!img) return;

            function computeAndApply() {
                try {
                    // create small canvas to speed up processing
                    const canvas = document.createElement('canvas');
                    const maxDim = 100; // scale image down to maximum dimension for sampling
                    let iw = img.naturalWidth || img.width;
                    let ih = img.naturalHeight || img.height;
                    if (!iw || !ih) return;
                    const scale = Math.min(1, maxDim / Math.max(iw, ih));
                    canvas.width = Math.max(1, Math.floor(iw * scale));
                    canvas.height = Math.max(1, Math.floor(ih * scale));
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    const data = ctx.getImageData(0, 0, canvas.width, canvas.height).data;

                    let r = 0, g = 0, b = 0, count = 0;
                    // sample every sampleStep-th pixel
                    for (let i = 0; i < data.length; i += 4 * sampleStep) {
                        r += data[i];
                        g += data[i + 1];
                        b += data[i + 2];
                        count++;
                    }
                    if (count === 0) return;
                    r = Math.round(r / count);
                    g = Math.round(g / count);
                    b = Math.round(b / count);
                    const rgb = `rgb(${r}, ${g}, ${b})`;
                    document.documentElement.style.setProperty(cssVarName, rgb);
                } catch (err) {
                    console.warn('Color extraction failed:', err);
                }
            }

            if (img.complete && img.naturalWidth) {
                computeAndApply();
            } else {
                img.addEventListener('load', computeAndApply);
                img.addEventListener('error', function() { console.warn('Palette image failed to load:', img.src); });
            }
        }

        // Run on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            applyAverageColorFromImage('palette-source');
        });
    </script>
</body>
</html>