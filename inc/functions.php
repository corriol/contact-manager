<?php
function getProvinces(): array
{
    $iso = [];

    $iso = file_get_contents('iso-3166-2.json');

    // transforming json to an associative array
    $worldProvinces = json_decode($iso, true);

    // filtering by Spain divisions
    $provinces = $worldProvinces["ES"]["divisions"];

    // sorting by value
    asort($provinces);

    // var_dump($provinces);
    return $provinces;
}

function create_connection(string $dsn, $user, $password): PDO {
    $pdo = new PDO("$dsn", $user, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}