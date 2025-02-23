<?php
class Contact {
    private $conn;
    private $table_name = "contacts";

    public $id;
    public $name;
    public $email;
    public $message;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                 (name, email, message) 
                 VALUES 
                 (:name, :email, :message)";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->message = htmlspecialchars(strip_tags($this->message));

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":message", $this->message);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function sendEmail() {
        $to = "your-email@example.com"; // Replace with your email
        $subject = "New Contact Form Submission";
        
        $message = "Name: {$this->name}\n";
        $message .= "Email: {$this->email}\n\n";
        $message .= "Message:\n{$this->message}";
        
        $headers = "From: {$this->email}\r\n";
        $headers .= "Reply-To: {$this->email}\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        return mail($to, $subject, $message, $headers);
    }

    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function validate() {
        $errors = [];

        if(empty($this->name)) {
            $errors[] = "Name is required";
        }

        if(empty($this->email)) {
            $errors[] = "Email is required";
        } elseif(!$this->validateEmail($this->email)) {
            $errors[] = "Invalid email format";
        }

        if(empty($this->message)) {
            $errors[] = "Message is required";
        }

        return $errors;
    }
}
?>