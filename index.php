<?php
session_start();

$controller = $_GET['controller'] ?? 'home';
$action     = $_GET['action'] ?? 'index';

// Xác định file Controller cần nạp
$controllerClass = ucfirst($controller) . 'Controller';
$controllerFile  = __DIR__ . "/controllers/{$controllerClass}.php";

if (!file_exists($controllerFile)) {
    http_response_code(404); exit("Controller không tồn tại.");
}

// Nạp file controller và tạo đối tượng
require_once $controllerFile;
$ctrl = new $controllerClass();

if (!method_exists($ctrl, $action)) {
    http_response_code(404); exit("Action không tồn tại.");
}

//Gọi action (method) tương ứng
$ctrl->$action();
