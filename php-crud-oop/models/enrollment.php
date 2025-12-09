<?php
class Enrollment {
    private $conn;
    private $table = "enrollments";

    public $id;
    public $StudentID;
    public $ProgramID;
    public $CourseID;
    public $Grade;
    public $Semester;
    public $SchoolYear;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE
    public function create() {
        $query = "INSERT INTO " . $this->table . " (StudentID, ProgramID, CourseID, Grade, Semester, SchoolYear) VALUES (:StudentID, :ProgramID, :CourseID, :Grade, :Semester, :SchoolYear)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':StudentID', $this->StudentID);
        $stmt->bindParam(':ProgramID', $this->ProgramID);
        $stmt->bindParam(':CourseID', $this->CourseID);
        $stmt->bindParam(':Grade', $this->Grade);
        $stmt->bindParam(':Semester', $this->Semester);
        $stmt->bindParam(':SchoolYear', $this->SchoolYear);
        return $stmt->execute();
    }

    // READ
    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // UPDATE
    public function update() {
        $query = "UPDATE " . $this->table . " SET StudentID = :StudentID, ProgramID = :ProgramID, CourseID = :CourseID, Grade = :Grade, Semester = :Semester, SchoolYear = :SchoolYear WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':StudentID', $this->StudentID);
        $stmt->bindParam(':ProgramID', $this->ProgramID);
        $stmt->bindParam(':CourseID', $this->CourseID);
        $stmt->bindParam(':Grade', $this->Grade);
        $stmt->bindParam(':Semester', $this->Semester);
        $stmt->bindParam(':SchoolYear', $this->SchoolYear);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // DELETE
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
