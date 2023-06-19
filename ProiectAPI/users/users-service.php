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

function get_user($identifier)
{
    global $db;

    $stmt = $db->prepare("SELECT id, username, email, date_of_birth, phone_number, country, gender, is_admin, profile_picture_path FROM users WHERE username = ? OR email = ?");

    if (!$stmt) {
        http_response_code(500);
        $response['status'] = 'failure';
        $response['errors'] = ['error-general' => 'A aparut o eroare pe server!'];
        return $response;
    }

    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();

    $result = $stmt->get_result();

    if (!$result) {
        http_response_code(500);
        $response['status'] = 'failure';
        $response['errors'] = ['error-general' => 'A aparut o eroare pe server!'];
        return $response;
    }

    $user = $result->fetch_assoc();

    $stmt->close();

    return $user;
}

function get_users()
{
    global $db;

    $stmt = $db->prepare("SELECT id, username, email, date_of_birth, phone_number, country, gender, is_admin, profile_picture_path FROM users WHERE id != 0");

    if (!$stmt) {
        http_response_code(500);
        die('A survenit o eroare la pregatirea interogarii');
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        http_response_code(500);
        die('A survenit o eroare la obținerea rezultatelor');
    }

    $users = array();

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    $stmt->close();

    return $users;
}

function post_user()
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

    $requiredFields = ['username', 'password', 'email'];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            http_response_code(400);
            $response['status'] = 'failure';
            $response['errors'] = ['error-general' => 'It is necessary to provide the username, password, and email of the user!'];
            return $response;
        }
    }

    if (get_user($data['username']) != null) {
        http_response_code(400);
        $response['status'] = 'failure';
        $response['errors'] = ['error-username' => 'This username is already taken!'];
        return $response;
    }

    if (get_user($data['email']) != null) {
        http_response_code(400);
        $response['status'] = 'failure';
        $response['errors'] = ['error-email' => 'This email is already taken!'];
        return $response;
    }

    $stmt = $db->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");

    $encrypted_password = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt->bind_param('sss', $data['username'], $encrypted_password, $data['email']);
    $stmt->execute();

    if (isset($data['dateOfBirth'])) {
        $stmt = $db->prepare("UPDATE users SET date_of_birth = ? WHERE username = ?");
        $stmt->bind_param('ss', $data['dateOfBirth'], $data['username']);
        $stmt->execute();
    }

    if (isset($data['phone_number'])) {
        $stmt = $db->prepare("UPDATE users SET phone_number = ? WHERE username = ?");
        $stmt->bind_param('ss', $data['phone_number'], $data['username']);
        $stmt->execute();
    }

    if (isset($data['country'])) {
        $stmt = $db->prepare("UPDATE users SET country = ? WHERE username = ?");
        $stmt->bind_param('ss', $data['country'], $data['username']);
        $stmt->execute();
    }

    if (isset($data['gender'])) {
        $stmt = $db->prepare("UPDATE users SET gender = ? WHERE username = ?");
        $stmt->bind_param('ss', $data['gender'], $data['username']);
        $stmt->execute();
    }

    $response['status'] = 'success';
    $response['data'] = get_user($data['username']);

    return $response;
}

function put_user($identifier)
{
    global $db;
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (!isset($data['key']) || $data['key'] != 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx') {
        http_response_code(403);
        return ['error' => 'Invalid key! This API is only for internal use!'];
    }

    $response = [];

    if ($data === null) {
        http_response_code(400);
        $response['status'] = 'failure';
        $response['errors'] = ['error-general' => 'Empty JSON data!'];
        return $response;
    }

//    foreach ($requiredFields as $field) {
//        if (!isset($data[$field])) {
//            $response['status'] = 'failure';
//            $response['errors'] = ['error-general' => 'It is necessary to provide the username, password, and email of the user!'];
//            return $response;
//        }
//    }

    if ($data['profile_picture_path'] == 'none') {
        $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, gender = ?, date_of_birth = ?,country = ?, phone_number = ? WHERE id = ?");

        $stmt->bind_param('ssssssi', $data['username'], $data['email'],
            $data['gender'], $data['dateOfBirth'], $data['country'], $data['phone'], $identifier);
    } else {

        $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, gender = ?, date_of_birth = ?,country = ?, phone_number = ?, profile_picture_path = ? WHERE id = ?");

        $stmt->bind_param('sssssssi', $data['username'], $data['email'],
            $data['gender'], $data['dateOfBirth'], $data['country'], $data['phone'], $data['profile_picture_path'], $identifier);
    }
    $stmt->execute();

    if (trim($data['password']) !== '') {
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $encrypted_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bind_param('si', $encrypted_password, $identifier);
        $stmt->execute();
    }

//    var_dump(get_user($data['username']));
//    return null;
//
//    if (isset($data['name'])) {
//        $stmt = $db->prepare("UPDATE users SET name = ? WHERE username = ?");
//        $stmt->bind_param('ss', $data['name'], $data['username']);
//        $stmt->execute();
//    }
//
//    if (isset($data['age'])) {
//        $stmt = $db->prepare("UPDATE users SET age = ? WHERE username = ?");
//        $stmt->bind_param('is', $data['age'], $data['username']);
//        $stmt->execute();
//    }
//
//    if (isset($data['phone_number'])) {
//        $stmt = $db->prepare("UPDATE users SET phone_number = ? WHERE username = ?");
//        $stmt->bind_param('ss', $data['phone_number'], $data['username']);
//        $stmt->execute();
//    }
//
//    if (isset($data['country'])) {
//        $stmt = $db->prepare("UPDATE users SET country = ? WHERE username = ?");
//        $stmt->bind_param('ss', $data['country'], $data['username']);
//        $stmt->execute();
//    }
//
//    if (isset($data['gender'])) {
//        $stmt = $db->prepare("UPDATE users SET gender = ? WHERE username = ?");
//        $stmt->bind_param('ss', $data['gender'], $data['username']);
//        $stmt->execute();
//    }

    $response['status'] = 'success';
    $response['data'] = $data;

    return $response;
}

function delete_user($username)
{
    global $db;

    $body = json_decode(file_get_contents('php://input'), true);
    if (!isset($body['key']) || $body['key'] != 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx') {
        http_response_code(401);
        return ['error' => 'Invalid key! This API is only for internal use!'];
    }

    $stmt = $db->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();

    if ($stmt->affected_rows == 0) {
        http_response_code(404);
        $response['status'] = 'failure';
        $response['errors'] = ['error-general' => 'User not found!'];
        return $response;
    }

    $response = [];
    $response['status'] = 'success';
    $response['data'] = $username;

    return $response;
}