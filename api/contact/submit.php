<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->email) && !empty($data->message)) {
    try {
        $query = "INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)";
        $stmt = $db->prepare($query);
        
        // Sanitize inputs
        $name = htmlspecialchars(strip_tags($data->name));
        $email = htmlspecialchars(strip_tags($data->email));
        $message = htmlspecialchars(strip_tags($data->message));
        
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":message", $message);
        
        if($stmt->execute()) {
            // Send email
            $to = "your-email@example.com";
            $subject = "New Contact Form Submission";
            $email_message = "Name: $name\n";
            $email_message .= "Email: $email\n\n";
            $email_message .= "Message:\n$message";
            
            $headers = "From: $email";
            
            mail($to, $subject, $email_message, $headers);
            
            http_response_code(201);
            echo json_encode(array("message" => "Contact form submitted successfully."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to submit form."));
        }
    } catch(PDOException $e) {
        http_response_code(503);
        echo json_encode(array("message" => "Database error: " . $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to submit form. Data is incomplete."));
}
?>