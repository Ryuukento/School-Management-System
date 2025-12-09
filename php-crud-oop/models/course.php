<?php
class Course {
    private $conn;
    private $table = "course";

    public $id;
    public $CourseName;
    public $Units;
    public $program_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE
    public function create() {
        $query = "INSERT INTO " . $this->table . " (CourseName, Units, program_id) VALUES (:CourseName, :Units, :program_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':CourseName', $this->CourseName);
        $stmt->bindParam(':Units', $this->Units);
        $stmt->bindParam(':program_id', $this->program_id);
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
        $query = "UPDATE " . $this->table . " SET CourseName = :CourseName, Units = :Units, program_id = :program_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':CourseName', $this->CourseName);
        $stmt->bindParam(':Units', $this->Units);
        $stmt->bindParam(':program_id', $this->program_id);
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
