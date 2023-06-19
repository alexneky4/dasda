<?php

function sendRegisterUserRequest($username, $email, $password, $dateOfBirth, $gender, $country) {
    $userData = array(
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'dateOfBirth' => $dateOfBirth,
        'gender' => $gender,
        'country' => $country
    );

    $jsonData = json_encode($userData);

    $url = 'localhost/ProiectAPI/users/';

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    $result = [];

    if($response === false) {
        $result['error-general'] = curl_error($curl);
        $result['status'] = 'error';
        return $result;
    }

    curl_close($curl);

    $responseData = json_decode($response, true);

    if($responseData['status'] === 'success') {
        $result['status'] = 'success';
        return $result;
    } else {
        $result = $responseData['errors'];
        $result['status'] = 'error';
        return $result;
    }
}

