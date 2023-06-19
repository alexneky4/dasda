<?php
session_start();
if(empty($_SESSION["username"]))
{
    HEADER("Location: /Proiect/login");
    exit;
}

if($_SESSION["is_admin"] == 0)
{
    HEADER("Location: /Proiect/home");
    exit;
}

require __DIR__ . '\..\models\admin-model.php';

function showAdminPage()
{
    $users = getAllUsers();
    $forms = getAllForms();
    $tags = getAllTags();


    require __DIR__ . '\..\views\admin-view.php';
}