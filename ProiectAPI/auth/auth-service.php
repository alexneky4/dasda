<?php

$db = new mysqli (
    'localhost',
    'root',
    '',
    'emof'
);

if (mysqli_connect_errno()) {
    die ('Conexiunea a esuat...');
}

header("Content-Type: application/json");

function login_user()
{
    global $db;

    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    $response = [];

    if ($data === null) {
        http_response_code(400);
        $response['status'] = 'failure';
        $response['errors'] = ['error-general' => 'Empty JSON data!'];
        return $response;
    }

    if(!isset($data['key']) || $data['key'] != 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx') {
        http_response_code(400);
        $response['status'] = 'failure';
        $response['errors'] = ['error-general' => 'Invalid key! This API is only for internal use!'];
        return $response;
    }

    $requiredFields = ['username', 'password'];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            http_response_code(400);
            $response['status'] = 'failure';
            $response['errors'] = ['error-general' => 'It is necessary to provide the username and the password!'];
            return $response;
        }
    }

    $stmt = $db->prepare("SELECT id, password, username, email, date_of_birth, phone_number, country, gender, is_admin, profile_picture_path FROM users WHERE BINARY username = ?");

    if (!$stmt) {
        http_response_code(500);
        $response['status'] = 'failure';
        $response['errors'] = ['error-general' => 'A survenit o eroare la pregatirea interogarii'];
        return $response;
    }

    $stmt->bind_param('s', $data['username']);
    $stmt->execute();

    $result = $stmt->get_result();

    if (!$result) {
        http_response_code(500);
        $response['status'] = 'failure';
        $response['errors'] = ['error-general' => 'A aparut o eroare pe server!'];
        return $response;
    }

    $user = $result->fetch_assoc();

    if($user === null) {
        http_response_code(404);
        $response['status'] = 'failure';
        $response['errors'] = ['error-username' => 'No account exists with this username!'];
        return $response;
    }

    if(password_verify($data['password'], $user['password']) === false) {
        http_response_code(400);
        $response['status'] = 'failure';
        $response['errors'] = ['error-password' => 'Incorrect password!'];
        return $response;
    }

    $stmt->close();

    $response['status'] = 'success';
    $response['data'] = $user;

    return $response;
}