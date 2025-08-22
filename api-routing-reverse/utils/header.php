<?php

function getHeaderAuth() {
    if (isset($_SERVER['Authorization'])) return trim($_SERVER['Authorization']);
    
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) return trim($_SERVER['HTTP_AUTHORIZATION']);
    
    if (function_exists('apache_request_headers')) {
        $requestHeaders = array_combine(array_map('ucwords', array_keys(apache_request_headers())), apache_request_headers());
        if (isset($requestHeaders['Authorization'])) return trim($requestHeaders['Authorization']);
    }

    return null;
}

function getToken() {
    if ($headers = getHeaderAuth()) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) return $matches[1];
    }

    return null;
}
