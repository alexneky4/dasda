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

function cat_sort($id, $component, $ages, $date) {
    date_default_timezone_set('Europe/Bucharest');
    global $db;
    $numbers = array();
    foreach($ages as $age) {
        $numbers[] = explode(",", $age);
    }
    $currentDate = date("Y-m-d H:i:s");
    $timeconvert = strtotime($currentDate);
    if($date == "1") $time = $timeconvert - $timeconvert;
    else if($date == "1h") $time = $timeconvert - (60 * 60);
    else if($date == "6h") $time = $timeconvert - (6 * 60 * 60);
    else if($date == "12h") $time = $timeconvert - (12 * 60 * 60);
    else if($date == "24h") $time = $timeconvert - (24 * 60 * 60);
    else if($date == "1w") $time = $timeconvert - (7 * 24 * 60 * 60);
    else if($date == "1m") $time = $timeconvert - (4 * 7 * 24 * 60 * 60);
    else if($date == "1y") $time = $timeconvert - (12 * 4 * 7 * 24 * 60 * 60);
    $datetime = date("Y-m-d H:i:s", $time);
    $results = array();
    foreach($numbers as $age_interval) {
        $age1 = intval($age_interval[0]);
        $age2 = intval($age_interval[1]);
        if(intval($component) === -1) {
            $statement = $db->prepare("SELECT emotion,COUNT(emotion) from `form-responses` fr JOIN users u ON fr.user_id = u.id
                                            WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= ? AND TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= ? 
                                                AND fr.response_date >= ? AND fr.form_id = ? GROUP BY emotion");
            $statement->bind_param('iisi', $age1, $age2, $datetime, $id);
        }
        else {
            $statement = $db->prepare("SELECT emotion, COUNT(emotion) from `component-responses` cr JOIN users u ON cr.user_id = u.id 
                                   JOIN `form_components` fc ON fc.id = cr.component_id
                                   WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= ? && TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= ? 
                                   && cr.response_date >= ? AND cr.component_id = ? AND fc.form_id = ? GROUP BY emotion");

            $statement->bind_param('iisii', $age1, $age2, $datetime, $component, $id);
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
        $ageString = ' for the ages:' .$age1. ','.$age2;
        if(intval($component) !== -1)
            $results['component-id: ' .$component. $ageString] = $forms;
        else
            $results['form'. $ageString] = $forms;
    }

    return $results;
}

//var_dump(cat_sort());
?>
