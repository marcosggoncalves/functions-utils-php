<?php

$origin = isset($_SERVER['HTTP_ORIGIN']) ?  $_SERVER['HTTP_ORIGIN'] : '*';

header("Access-Control-Allow-Origin: $origin");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if ($method = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] ?? null)
        header("Access-Control-Allow-Methods: $method");

    if ($headers = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ?? null)
        header("Access-Control-Allow-Headers: $headers");

    exit;
}
