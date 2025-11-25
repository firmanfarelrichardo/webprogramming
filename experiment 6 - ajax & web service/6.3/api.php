<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $users = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com']
        ];
        echo json_encode(['status' => 'success', 'data' => $users]);
        break;
        
    case 'POST':

        $input = json_decode(file_get_contents('php://input'), true);
        
        if (empty($input['name']) || empty($input['email'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Name and email required']);
        } else {
            $newUser = [
                'id' => rand(100, 999),
                'name' => $input['name'],
                'email' => $input['email'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            echo json_encode(['status' => 'success', 'message' => 'User created', 'data' => $newUser]);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>