<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../classes/Task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);
$stmt = $task->read();
$num = $stmt->rowCount();

if($num > 0) {
    $tasks_arr = array();
    $tasks_arr["records"] = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $task_item = array(
            "id" => $id,
            "title" => $title,
            "completed" => $completed,
            "created_at" => $created_at
        );
        
        array_push($tasks_arr["records"], $task_item);
    }
    
    http_response_code(200);
    echo json_encode($tasks_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No tasks found."));
}
?>