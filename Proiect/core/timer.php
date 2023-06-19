<?php


function formatTimeRemaining($endTime) {
    date_default_timezone_set('Europe/Bucharest');
    $currentDateTime = new DateTime();
    $endDateTime = new DateTime($endTime);

    if ($endDateTime < $currentDateTime) {
        return '00:00:00';
    }

    $interval = $currentDateTime->diff($endDateTime);

    $formattedTime = '';

    if ($interval->days > 0) {
        $formattedTime .= str_pad($interval->days, 2, '0', STR_PAD_LEFT) . ':';
    }
    if ($interval->h > 0) {
        $formattedTime .= str_pad($interval->h, 2, '0', STR_PAD_LEFT) . ':';
    }
    $formattedTime .= str_pad($interval->i, 2, '0', STR_PAD_LEFT) . ':';
    $formattedTime .= str_pad($interval->s, 2, '0', STR_PAD_LEFT);

    return $formattedTime;
}