<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/enrollment.php';

class EnrollmentController {
    private $db;
    private $StudentID;
    private $programID;
    private $CourseID;
    private $Grade;
    private $Semester;
    private $SchoolYear;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->enrollment = new Enrollment($this->db);
    }

    public function create($StudentID, $ProgramID, $CourseID, $Grade, $Semester, $SchoolYear) {
        $this->enrollment->StudentID = $StudentID;
        $this->enrollment->ProgramID = $ProgramID;
        $this->enrollment->CourseID = $CourseID;
        $this->enrollment->Grade = $Grade;
        $this->enrollment->Semester = $Semester;
        $this->enrollment->SchoolYear = $SchoolYear;
        return $this->enrollment->create();
    }

    public function readAll() {
        return $this->enrollment->read();
    }

    public function update($id, $StudentID, $ProgramID, $CourseID, $Grade, $Semester, $SchoolYear) {
        $this->enrollment->id = $id;
        $this->enrollment->StudentID = $StudentID;
        $this->enrollment->ProgramID = $ProgramID;
        $this->enrollment->CourseID = $CourseID;
        $this->enrollment->Grade = $Grade;
        $this->enrollment->Semester = $Semester;
        $this->enrollment->SchoolYear = $SchoolYear;
        return $this->enrollment->update();
    }

    public function delete($id) {
        $this->enrollment->id = $id;
        return $this->enrollment->delete();
    }
}