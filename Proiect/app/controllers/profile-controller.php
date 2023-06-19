<?php
session_start();

require __DIR__ . '\..\models\profile-model.php';

if(isset($_SESSION['profile_picture_path']) && $_SESSION['profile_picture_path']) {
    $profile_picture_path = "/Proiect/public/resources/images/users/" . $_SESSION['profile_picture_path'];
} else {
    $profile_picture_path = '/Proiect/public/resources/images/no-profile-picture.jpg';
}

if (isset($_SESSION['id'])) {
    $response_forms_created = get_forms_created($_SESSION['id']);
    $forms_created = json_decode($response_forms_created['data']);
    $error_created = $response_forms_created['error'];
    if (empty($forms_created) === true) {
        $forms_created = array();
    }

    $response_forms_taken = get_forms_taken($_SESSION['id']);
    $forms_taken = json_decode($response_forms_taken['data']);
    $error_taken = $response_forms_taken['error'];
    if (empty($forms_taken) === true) {
        $forms_taken = array();
    }
} else {
    $forms_created = array();
    $forms_taken = array();
}

require __DIR__ . '\..\..\core\timer.php';
require __DIR__ . '\..\views\profile-view.php';


