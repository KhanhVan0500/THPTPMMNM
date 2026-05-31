<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
class AccountController {
private $accountModel;

private $db;
public function __construct() {
$this->db = (new Database())->getConnection();
$this->accountModel = new AccountModel($this->db);
}
public function register() {
include_once 'app/views/account/register.php';
}
public function login() {
include_once 'app/views/account/login.php';
}
public function save() {
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$username = trim($_POST['email'] ?? '');
$requestedRole = $_POST['role'] ?? 'user';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmpassword'] ?? '';
$errors = [];
if (empty($username)) {
	$errors['username'] = "Vui lòng nhập email Gmail!";
} elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
	$errors['username'] = "Email không đúng định dạng!";
}
// Password strength: min 8 chars, at least one uppercase, one number, one special char
if (empty($password)) {
	$errors['password'] = "Vui lòng nhập password!";
} else {
	$pattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/';
	if (!preg_match($pattern, $password)) {
		$errors['password'] = "Mật khẩu phải từ 8 ký tự, có chữ in hoa, số và ký tự đặc biệt.";
	}
}
if ($password != $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";

$cfg = include __DIR__ . '/../config/config.php';
$role = 'user';
if ($requestedRole === 'admin') {
	$canBeAdmin = false;
	if (!$this->accountModel->hasAdmin()) {
		$canBeAdmin = true;
	} elseif (!empty($cfg['admin_emails']) && is_array($cfg['admin_emails']) && in_array($username, $cfg['admin_emails'], true)) {
		$canBeAdmin = true;
	}

	if ($canBeAdmin) {
		$role = 'admin';
	} else {
		$errors['role'] = "Chỉ tài khoản admin đầu tiên hoặc email được cấu hình mới có thể đăng ký quyền admin.";
	}
}

if ($this->accountModel->getAccountByUsername($username)) {
	$errors['account'] = "Tài khoản này đã được đăng ký!";
}

if (count($errors) > 0) {
include_once 'app/views/account/register.php';
} else {
			$result = $this->accountModel->save($username, $password, $role);

if ($result) {
header('Location: /account/login');
exit;
}
}
}
}
public function logout() {

session_start();
unset($_SESSION['username']);
unset($_SESSION['role']);
header('Location: /Product');
exit;
}
public function checkLogin() {
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$username = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$account = $this->accountModel->getAccountByUsername($username);
if ($account && password_verify($password, $account->password)) {
session_start();
if (!isset($_SESSION['username'])) {
$_SESSION['username'] = $account->username;
$_SESSION['role'] = $account->role;
}
header('Location: /Product');
exit;
} else {
$error = $account ? "Mật khẩu không đúng!" : "Không tìm thấy tài

khoản!";

include_once 'app/views/account/login.php';
exit;
}
}
}
}
?>