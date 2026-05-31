<?php
session_start();
require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';

$url = $_GET['url'] ?? '';
$url = trim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerSegment = $url[0] ?? '';
$controllerName = $controllerSegment !== '' ? ucfirst(strtolower($controllerSegment)) . 'Controller' : 'ProductController';

// Kiểm tra phần thứ hai của URL để xác định action
$action = $url[1] ?? 'index';
$action = $action !== '' ? $action : 'index';

// Kiểm tra xem controller và action có tồn tại không
$controllerFile = 'app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerFile)) {
    http_response_code(404);
    die('Controller not found');
}

require_once $controllerFile;
$controller = new $controllerName();
if (!method_exists($controller, $action)) {
    http_response_code(404);
    die('Action not found');
}

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));