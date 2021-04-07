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
