<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/program.php';

class ProgramController {
    private $db;
    private $program;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->program = new Program($this->db);
    }

    public function create($ProgramName, $Description) {
        $this->program->ProgramName = $ProgramName;
        $this->program->Description = $Description;
        return $this->program->create();
    }

    public function readAll() {
        return $this->program->read();
    }

    public function update($id, $ProgramName, $Description) {
        $this->program->id = $id;
        $this->program->ProgramName = $ProgramName;
        $this->program->Description = $Description;
        return $this->program->update();
    }

    public function delete($id) {
        $this->program->id = $id;
        return $this->program->delete();
    }
}