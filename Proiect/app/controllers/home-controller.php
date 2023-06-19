<?php
session_start();

require __DIR__ . '\..\models\home-model.php';

function formsWithoutQuery()
{
    $response_forms = getAllForms();
    mainView($response_forms);
}

function formsWithQuery($query)
{
    $response_forms = getFormsByQuery($query);
    mainView($response_forms);
}

function mainView($response_forms)
{
    if (isset($_SESSION['profile_picture_path']) && $_SESSION['profile_picture_path']) {
        $profile_picture_path = "/Proiect/public/resources/images/users/" . $_SESSION['profile_picture_path'];
    } else {
        $profile_picture_path = '/Proiect/public/resources/images/no-profile-picture.jpg';
    }

    $forms = json_decode($response_forms['data']);
    $error_forms = $response_forms['error'];

    $response_tags = getAllTags();
    $tags = json_decode($response_tags['data']);
    $error_tags = $response_tags['error'];

    if (isset($_SESSION['id']))
        $name = $_SESSION['username'];
    else $name = "User anonim";

    require __DIR__ . '\..\..\core\timer.php';
    require __DIR__ . '\..\views\home-view.php';
}
