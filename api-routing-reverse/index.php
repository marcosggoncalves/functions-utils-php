<?php

require __DIR__ . '/config/cors.php';
require __DIR__ . '/config/params.php';
require __DIR__ . '/utils/render.php';
require __DIR__ . '/utils/header.php';

$request_painel = $_SERVER;
$request_body = file_get_contents('php://input');
$request_method_especial = array_search($request_painel['REQUEST_METHOD'], ['POST', 'PATCH']);
$request_replace_path = str_replace(GATEWAY_PATH, "", $request_painel['REQUEST_URI']);
$request_endpoint = API_PATH . $request_replace_path;
$request_api = curl_init();


try {
    curl_setopt_array($request_api, [
        CURLOPT_URL            => $request_endpoint,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json', 'authorization: Bearer ' . getToken()],
        CURLOPT_RETURNTRANSFER => true,
    ]);

    if (isset($request_painel) &&  $request_method_especial >= 0) {
        curl_setopt_array($request_api, [
            CURLOPT_CUSTOMREQUEST  => $request_painel['REQUEST_METHOD'],
            CURLOPT_POSTFIELDS => $request_body,
        ]);
    } else {
        curl_setopt($request_api, CURLOPT_CUSTOMREQUEST, $request_painel['REQUEST_METHOD']);
    }

    $response = curl_exec($request_api);
    response_send(curl_getinfo($request_api, CURLINFO_HTTP_CODE), $response);
} catch (Exception $e) {
    response_send(500, $e->getMessage(), true);
} finally {
    curl_close($request_api);
}
