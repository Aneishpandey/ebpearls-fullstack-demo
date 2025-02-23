<?php
class Task {
    private $conn;
    private $table_name = "tasks";

    public $id;
    public $title;
    public $completed;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create task
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (title) VALUES (:title)";
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->title = htmlspecialchars(strip_tags($this->title));
        
        $stmt->bindParam(":title", $this->title);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read all tasks
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update task status
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET completed = :completed 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":completed", $this->completed);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete task
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>