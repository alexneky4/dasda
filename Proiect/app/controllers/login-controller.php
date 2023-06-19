<?php

session_start();
if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
{
    HEADER("Location: /Proiect/home");
    exit;
}

require __DIR__ . '\..\models\login-model.php';

function showLoginPage() {
    $message = isset($_GET['message']) ? $_GET['message'] : '';

    $formValues = array(
        'username' => isset($_GET['username']) ? $_GET['username'] : '',
    );

    $errors = array(
        'general' => null,
        'username' => null,
        'password' => null,
    );

    if(isset($_GET['error-general'])) {
        $errors['general'] = $_GET['error-general'];
    }

    foreach ($errors as $errorType => &$errorValue) {
        if (isset($_GET['error-' . $errorType])) {
            $errorValue = $_GET['error-' . $errorType];
        }
    }

    require __DIR__ . '\..\views\login-view.php';
}

function loginUser() {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $data = [];

    if(strlen($username) === 0) {
        $data['error-username'] = 'Username is required';
    }

    if(strlen($password) === 0) {
        $data['error-password'] = 'Password is required';
    }

    if(count($data) > 0) {
        $data['username'] = $username;
        $queryString = http_build_query($data);
        header("Location: ?$queryString");
        exit();
    }

    $responseData = sendLoginRequest($username, $password);

     if($responseData['status'] === 'success') {
        session_start(['cookie_lifetime' => 7 * 24 * 60 * 60]);
        $_SESSION['id'] = $responseData['data']['id'];
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $responseData['data']['email'];
        $_SESSION['date_of_birth'] = $responseData['data']['date_of_birth'];
        $_SESSION['phone_number'] = $responseData['data']['phone_number'];
        $_SESSION['country'] = $responseData['data']['country'];
        $_SESSION['gender'] = $responseData['data']['gender'];
        $_SESSION['is_admin'] = $responseData['data']['is_admin'];
        $_SESSION['profile_picture_path'] = $responseData['data']['profile_picture_path'];

        header('Location: home');
        exit();
    } else {
        $errors = $responseData['errors'];
        $errors['username'] = $username;
        $queryString = http_build_query($errors);
        header("Location: ?$queryString");
        exit();
    }
}