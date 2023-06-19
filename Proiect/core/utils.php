<?php
class Utils {
    public static function isValidCountry($country) {
        $json = file_get_contents(__DIR__ . '\..\config\config.json');
        $config = json_decode($json, true);

        return in_array($country, $config['countries']);
    }
}
