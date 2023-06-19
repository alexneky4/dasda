<?php
session_start();
if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
{
    HEADER("Location: /Proiect/home");
    exit;
}

require __DIR__ . '\..\views\index-view.html';
