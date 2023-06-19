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


function get_all_responses()
{
    global $db;

    $rez = $db->execute_query("SELECT form_id FROM `form-responses`");
    if (!$rez) {
        http_response_code(500);
        die('A survenit o eroare la interogare');
    }

    $forms = array();
    while ($inreq = $rez->fetch_assoc()) {
        $forms[$inreq['form_id']] = get_responses_for_form($inreq['form_id']);
    }

    if (empty($forms)) {
        // Return 404 Not Found if no forms are found
        http_response_code(404);
        return array('error' => 'No forms that have been responded found');
    }
    return $forms;
}

function get_responses_for_form($formId)
{
    global $db;

    $stmt = $db->prepare("SELECT user_id, emotion, description,response_date FROM `form-responses` WHERE form_id = ?");
    $stmt->bind_param("i", $formId);
    $stmt->execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        die('A survenit o eroare la interogare');
    }

    $formResponse = array();
    while ($response = $rez->fetch_assoc()) {
        $components = array();
        $stmt2 = $db->prepare("SELECT cr.component_id, cr.emotion, cr.description, cr.response_date FROM `component-responses` cr
                                        JOIN `form_components` fc ON fc.id = cr.component_id WHERE fc.form_id = ? AND cr.user_id = ?");
        $stmt2->bind_param("ii", $formId, $response['user_id']);
        $stmt2->execute();

        $rez2 = $stmt2->get_result();
        if (!$rez2) {
            http_response_code(500);
            die('A survenit o eroare la interogare');
        }

        while ($response_component = $rez2->fetch_assoc()) {
            $components[$response_component['component_id']] = array(
                "emotion" => $response_component['emotion'],
                "description" => $response_component['description'],
                "responseDate" => $response_component['response_date']
            );
        }
        $userResponse = array(
            "emotion" => $response['emotion'],
            "description" => $response['description'],
            "responseDate" => $response['response_date'],
            "components" => $components
        );
        $formResponse[$response['user_id']] = $userResponse;
    }
    if (empty($formResponse)) {
        // Return 404 Not Found if no forms are found
        http_response_code(404);
        return array('error' => 'No form responses found');
    }
    return $formResponse;
}

function get_response_form_user($formId, $userId)
{
    global $db;

    $stmt = $db->prepare("SELECT emotion, description,response_date FROM `form-responses` WHERE form_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $formId, $userId);
    $stmt->execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        die('A survenit o eroare la interogare');
    }

    $response = $rez->fetch_assoc();
    $components = array();
    $stmt2 = $db->prepare("SELECT cr.component_id, cr.emotion, cr.description, cr.response_date FROM `component-responses` cr
                                        JOIN `form_components` fc ON fc.id = cr.component_id WHERE fc.form_id = ? AND cr.user_id = ?");
    $stmt2->bind_param("ii", $formId, $userId);
    $stmt2->execute();

    $rez2 = $stmt2->get_result();
    if (!$rez2) {
        http_response_code(500);
        die('A survenit o eroare la interogare');
    }

    while ($response_component = $rez2->fetch_assoc()) {
        $components[$response_component['component_id']] = array(
            "emotion" => $response_component['emotion'],
            "description" => $response_component['description'],
            "responseDate" => $response_component['response_date']
        );
    }
    $userResponse = array(
        "emotion" => $response['emotion'],
        "description" => $response['description'],
        "responseDate" => $response['response_date'],
        "components" => $components
    );

    return $userResponse;
}

function get_responses_for_component($id, $component, $ages, $date)
{
    date_default_timezone_set('Europe/Bucharest');
    global $db;
    $numbers = array();
    foreach ($ages as $age) {
        $numbers[] = explode(",", $age);
    }
    $currentDate = date("Y-m-d H:i:s");
    $timeconvert = strtotime($currentDate);
    if ($date == "1") $time = $timeconvert;
    else if ($date == "1h") $time = $timeconvert - (60 * 60);
    else if ($date == "6h") $time = $timeconvert - (6 * 60 * 60);
    else if ($date == "12h") $time = $timeconvert - (12 * 60 * 60);
    else if ($date == "24h") $time = $timeconvert - (24 * 60 * 60);
    else if ($date == "1w") $time = $timeconvert - (7 * 24 * 60 * 60);
    else if ($date == "1m") $time = $timeconvert - (4 * 7 * 24 * 60 * 60);
    else if ($date == "1y") $time = $timeconvert - (12 * 4 * 7 * 24 * 60 * 60);
    $datetime = date("Y-m-d H:i:s", $time);
    $results = array();
    foreach ($numbers as $age_interval) {

        $age1 = intval($age_interval[0]);
        $age2 = intval($age_interval[1]);
        if(intval($component) === -1)
        {
            $statement = $db->prepare("SELECT u.username, fr.emotion, fr.description from `form-responses` fr JOIN users u ON fr.user_id = u.id
                                            WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= ? AND TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= ? 
                                            AND fr.response_date <= ? AND fr.form_id = ?");
            $statement->bind_param('iisi', $age1, $age2, $datetime,$id);
        }
        else{
            $statement = $db->prepare("SELECT u.username, cr.emotion, cr.description from `component-responses` cr JOIN users u ON cr.user_id = u.id 
                                   JOIN `form_components` fc ON fc.id = cr.component_id
                                   WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= ? AND TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= ? 
                                   AND cr.response_date <= ? AND cr.component_id = ? AND fc.form_id = ?");

            $statement->bind_param('iisii', $age1, $age2, $datetime, $component,$id);
        }
        $statement->execute();
        $rez = $statement->get_result();
        if (!$rez) {
            http_response_code(500);
            die('A survenit o eroare la interogare');
        }

        $forms = array();

        while ($inreq = $rez->fetch_assoc()) {
            $forms[] = $inreq;
        }
        $results[] = $forms;

    }

    return $results;
}

function update_form_response()
{
    global $db;

    $body = json_decode(file_get_contents('php://input'), true);

    if (!isset($body['key']) || $body['key'] != 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx') {
        return ['error' => 'Invalid key! This API is only for internal use!'];
    }

    $stmt = $db->prepare('SELECT COUNT(*) FROM `form-responses` WHERE form_id = ? AND user_id = ?');
    $stmt->bind_param('ii', $body['form_id'], $body['user_id']);
    $stmt->execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        return ['error' => 'Database error'];
    }

    $count = $rez->fetch_assoc()['COUNT(*)'];

    if ($count == 0) {
        return create_form_response();
    }
    $stmt = $db->prepare('UPDATE `form-responses` SET emotion = ?, description = ?, response_date = ? WHERE form_id = ? AND user_id = ?');
    $stmt->bind_param('sssii', $body['emotion_main'], $body['description_main'], $body['response_date'], $body['form_id'], $body['user_id']);
    $stmt->execute();

    if(isset($body['components_responses'])) {
        for($i = 0; $i < count($body['components_responses']); $i++) {
            $stmt = $db->prepare('UPDATE `component-responses` SET emotion = ?, description = ?, response_date = ? WHERE component_id = ? AND user_id = ?');
            $stmt->bind_param('sssii', $body['components_responses'][$i]['emotion'], $body['components_responses'][$i]['description'], $body['components_responses'][$i]['response_date'], $body['components_responses'][$i]['component_id'], $body['user_id']);
            $stmt->execute();
        }
    }

    $response = [];
    $response['status'] = 'success';
    $response['edit'] = true;
    $response['response'] = get_response_form_user($body['form_id'], $body['user_id']);

    return $response;
}

function create_form_response()
{
    global $db;

    $body = json_decode(file_get_contents('php://input'), true);

    if (!isset($body['key']) || $body['key'] != 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx') {
        return ['error' => 'Invalid key! This API is only for internal use!'];
    }

    $stmt = $db->prepare('SELECT COUNT(*) FROM `form-responses` WHERE form_id = ? AND user_id = ?');
    $stmt->bind_param('ii', $body['form_id'], $body['user_id']);
    $stmt->execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        return ['error' => 'Database error'];
    }

    $count = $rez->fetch_assoc()['COUNT(*)'];

    if ($count != 0) {
        return update_form_response();
    }

    if (!isset($body['emotion_main'])) {
        http_response_code(400);
        return ['emotion-main-error' => 'Can\'t be empty!'];
    }

    $stmt = $db->prepare('INSERT INTO `form-responses` (form_id, user_id, emotion, description, response_date) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('iisss', $body['form_id'], $body['user_id'], $body['emotion_main'], $body['description_main'], $body['response_date']);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        http_response_code(500);
        return ['error' => 'Database insert error'];
    }

    if (isset($body['components_responses'])) {
        for ($i = 0; $i < count($body['components_responses']); $i++) {
            $stmt = $db->prepare('INSERT INTO `component-responses` (component_id, user_id, emotion, description, response_date) VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param('iisss', $body['components_responses'][$i]['component_id'], $body['user_id'], $body['components_responses'][$i]['emotion'], $body['components_responses'][$i]['description'], $body['components_responses'][$i]['response_date']);
            $stmt->execute();

            if ($stmt->affected_rows === 0) {
                http_response_code(500);
                return ['error' => 'Database insert error'];
            }
        }
    }

    $response = [];
    $response['status'] = 'success';
    $response['response'] = get_response_form_user($body['form_id'], $body['user_id']);

    return $response;
}