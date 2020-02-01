<?php
header("Access-Control-Allow-Origin: *");

$path_ldz = "ldz.json";
$path_personally = "personally.json";
$path_reading = "reading.json";

if (array_key_exists("/save/ldz/", $_GET)) {
    saveLdz($path_ldz);
}

if (array_key_exists("/load/ldz/", $_GET)) {
    loadLdz($path_ldz);
}

if (array_key_exists("/save/personally/", $_GET)) {
    savePersonaly($path_personally);
}

if (array_key_exists("/load/personally/", $_GET)) {
    loadPersonally($path_personally);
}

if (array_key_exists("/save/reading/", $_GET)) {
    saveReading($path_reading);
}

if (array_key_exists("/load/reading/", $_GET)) {
    loadReading($path_reading);
}

/**
 * @param string $path_ldz
 */
function saveLdz(string $path_ldz): void
{
    $ldz = $_POST["ldz"];
    if (empty($ldz))
        json(false);
    $r = file_put_contents($path_ldz, $ldz);
    json($r > 0);
}

/**
 * @param string $path_ldz
 */
function loadLdz(string $path_ldz): void
{
    $ldz = json_decode(file_get_contents($path_ldz), true);
    json($ldz);
}

/**
 * @param string $path_personally
 */
function savePersonaly(string $path_personally): void
{
    $personally = $_POST["personally"];
    if (empty($personally))
        json(false);
    $r = file_put_contents($path_personally, $personally);
    json($r > 0);
}

/**
 * @param string $path_personally
 */
function loadPersonally(string $path_personally): void
{
    $ldz = json_decode(file_get_contents($path_personally), true);
    json($ldz);
}

/**
 * @param string $path_reading
 */
function saveReading(string $path_reading): void
{
    $reading = $_POST["reading"];
    if (empty($reading))
        json(false);
    $r = file_put_contents($path_reading, $reading);
    json($r > 0);
}

/**
 * @param string $path_reading
 */
function loadReading(string $path_reading): void
{
    $reading = json_decode(file_get_contents($path_reading), true);
    json($reading);
}

function json($obj): void
{
    header('Content-Type: application/json');
    echo json_encode($obj);
    exit;
}