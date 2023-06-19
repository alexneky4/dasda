<?php

function getFormById($id)
{
    $url = "localhost/ProiectAPI/forms/$id";

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($curl);

    curl_close($curl);

    return json_decode($result, true);
}

function saveResponse($data)
{
    $data['key'] = "bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx";

    $jsonData = json_encode($data);

    $url = 'localhost/ProiectAPI/responses/';

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    $result = [];

    if($response === false) {
        $result['status'] = 'failure';
        $result['errors'] = ['error' => curl_error($curl)];
        return $result;
    }

    if($httpCode != 200) {
        $result['status'] = 'failure';
        $result['errors'] = json_decode($response, true);
        return $result;
    }

    curl_close($curl);

    return json_decode($response, true);
}