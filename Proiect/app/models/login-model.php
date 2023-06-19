<?php

function sendLoginRequest($username, $password) {
    $data = array(
        'key' => "bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx",
        'username' => $username,
        'password' => $password
    );

    $jsonData = json_encode($data);

    $url = 'localhost/ProiectAPI/auth/';

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    $result = [];

    if($response === false) {
        $result['status'] = 'failure';
        $result['errors']['error-general'] = curl_error($curl);
        return $result;
    }

    curl_close($curl);

    $result = json_decode($response, true);

    return $result;
}