<?php
class Program {
    private $conn;
    private $table = "program";

    public $id;
    public $ProgramName;
    public $Description;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE
    public function create() {
        $query = "INSERT INTO " . $this->table . " (ProgramName, Description) VALUES (:ProgramName, :Description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ProgramName', $this->ProgramName);
        $stmt->bindParam(':Description', $this->Description);
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
        $query = "UPDATE " . $this->table . " SET ProgramName = :ProgramName, Description = :Description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ProgramName', $this->ProgramName);
        $stmt->bindParam(':Description', $this->Description);
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
