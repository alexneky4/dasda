<?php

function getAllTags()
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'localhost/ProiectAPI/tags/');
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($c);
    $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE);
    curl_close($c);
    $response = array(
        'data' => null,
        'error' => null
    );

    if ($httpCode == 200) {
        // Successful response
        $response['data'] = json_decode($result, true);
    } elseif ($httpCode == 404) {
        // No forms found
        $response['error'] = 'No tags found';
    } else {
        // Error occurred
        $response['error'] = 'An error occurred during the request';
    }

    return $response;
}

function tagNameToId($tagName) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, "localhost/ProiectAPI/tags/$tagName");
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($c);
    $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE);
    curl_close($c);
    $response = array(
        'data' => null,
        'error' => null
    );

    if ($httpCode == 200) {
        $response['data'] = json_decode($result, true);
    } elseif ($httpCode == 404) {
        $response['error'] = 'No tags found';
    } else {
        $response['error'] = 'An error occurred during the request';
    }

    return $response;
}

function saveForm($data)
{
    $data['key'] = "bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx";

    $jsonData = json_encode($data);

    $url = 'localhost/ProiectAPI/forms/';

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    $result = [];

    if ($response === false) {
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

    $result = json_decode($response, true);

    return $result;
}