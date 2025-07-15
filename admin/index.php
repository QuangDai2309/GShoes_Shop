<?php
session_start();

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

$controllerClass = ucfirst($controller) . 'Controller';
$controllerFile = __DIR__ . "/controllers/$controllerClass.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerClass)) {
        $obj = new $controllerClass();
        if (method_exists($obj, $action)) {
            $obj->$action();
        } else {
            echo "Action $action không tồn tại.";
        }
    } else {
        echo "Controller class $controllerClass không tồn tại.";
    }
} else {
    echo "File controller không tồn tại.";
}
