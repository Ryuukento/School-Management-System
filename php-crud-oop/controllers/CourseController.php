<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/course.php';

class CourseController {
    private $db;
    private $course;
    private $program_id;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->course = new Course($this->db);
    }

    public function create($CourseName, $Units, $program_id) {
        $this->course->CourseName = $CourseName;
        $this->course->Units = $Units;
        $this->course->program_id = $program_id;
        return $this->course->create();
    }

    public function readAll() {
        return $this->course->read();
    }

    public function update($id, $CourseName, $Units, $program_id) {
        $this->course->id = $id;
        $this->course->CourseName = $CourseName;
        $this->course->Units = $Units;
        $this->course->program_id = $program_id;
        return $this->course->update();
    }

    public function delete($id) {
        $this->course->id = $id;
        return $this->course->delete();
    }
}