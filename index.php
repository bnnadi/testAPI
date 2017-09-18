<?php
require_once "vendor/autoload.php";
require_once "config/config.php";
require_once 'api.php';

$api = new \WAG\API();

$api->init();

$request_uri = strtok($api->getRequestURI(), '?');
$requests = explode('/', trim($request_uri, '/'));
$parameter = 0;

if (count($requests) >= 2) {
    $version = $requests[0];
    $service = ucfirst($requests[1]);
    $action = 'index';

    if (count($requests) == 3) {
        if (is_numeric($requests[2]))
            $parameter = $requests[2];
        else
            $action = $requests[2];
    } elseif (count($requests) > 3) {
        $action = $requests[2];
        $parameter = $requests[3];
    }

    $controller = $api->getRequestController($service);

    if (method_exists($controller, $action)) {

        $controller->initialize($api, null);
        // TODO: Add permissions
        $controller->$action($parameter);

        header('Content-Type: application/json');
        $controller->respond();
    }
    else
        header('HTTP/1.0 404 Not Found');
}
else
    header('HTTP/1.0 404 Not Found');
die();
