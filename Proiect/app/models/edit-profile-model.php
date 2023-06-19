<?php
function sendUpdateUserRequest($id,$username, $email, $password, $dateOfBirth, $gender, $phone, $country, $profile_picture_path)
{
    $userData = array(
        'key' => 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx',
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'dateOfBirth' => $dateOfBirth,
        'phone' => $phone,
        'gender' => $gender,
        'country' => $country,
        'profile_picture_path' => $profile_picture_path
    );

    $jsonData = json_encode($userData);
    $url = 'localhost/ProiectAPI/users/' .$id;
    $curl = curl_init($url);

    echo $jsonData;

    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);

    echo $response;
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