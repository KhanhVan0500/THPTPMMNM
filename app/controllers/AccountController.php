<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/helpers/SessionHelper.php');

class AccountController {
    private $accountModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    private function requireLogin() {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /account/login');
            exit;
        }
    }

    private function requireAdmin() {
        $this->requireLogin();
        if (!SessionHelper::isAdmin()) {
            header('Location: /account/login');
            exit;
        }
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
            $fullname = trim($_POST['fullname'] ?? '');
            $requestedRole = $_POST['role'] ?? 'user';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập email Gmail!";
            } elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                $errors['username'] = "Email không đúng định dạng!";
            }

            if (empty($fullname)) {
                $errors['fullname'] = "Vui lòng nhập họ tên!";
            } elseif (mb_strlen($fullname) < 2) {
                $errors['fullname'] = "Họ tên phải ít nhất 2 ký tự.";
            }

            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập mật khẩu!";
            } else {
                $pattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/';
                if (!preg_match($pattern, $password)) {
                    $errors['password'] = "Mật khẩu phải từ 8 ký tự, có chữ in hoa, số và ký tự đặc biệt.";
                }
            }

            if ($password !== $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";
            }

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
                $verificationToken = bin2hex(random_bytes(32));
                $result = $this->accountModel->save($username, $password, $role, $fullname, $verificationToken);

                if ($result) {
                    $this->sendVerificationEmail($username, $verificationToken);
                    header('Location: /account/login?registered=1');
                    exit;
                }

                $errors['account'] = "Đăng ký không thành công, vui lòng thử lại.";
                include_once 'app/views/account/register.php';
            }
        }
    }

    public function logout() {
        SessionHelper::start();
        if (isset($_SESSION['username'])) {
            $this->accountModel->clearRememberToken($_SESSION['username']);
        }
        setcookie('remember_me', '', time() - 3600, '/');
        session_unset();
        session_destroy();
        header('Location: /Product');
        exit;
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                if ($account->is_locked) {
                    $error = "Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.";
                    include_once 'app/views/account/login.php';
                    exit;
                }

                if (password_verify($password, $account->password)) {
                    SessionHelper::start();
                    $_SESSION['username'] = $account->username;
                    $_SESSION['fullname'] = $account->fullname;
                    $_SESSION['role'] = $account->role;
                    $_SESSION['avatar'] = $account->avatar;

                    if ($remember) {
                        $rememberToken = bin2hex(random_bytes(32));
                        $this->accountModel->setRememberToken($username, $rememberToken);
                        setcookie('remember_me', $rememberToken, time() + 60 * 60 * 24 * 30, '/', '', false, true);
                    }

                    header('Location: /Product');
                    exit;
                }
                $error = "Mật khẩu không đúng!";
            } else {
                $error = "Không tìm thấy tài khoản!";
            }

            include_once 'app/views/account/login.php';
            exit;
        }
    }

    public function verify($token = '') {
        $success = false;
        $message = '';

        if (empty($token)) {
            $message = 'Liên kết xác thực không hợp lệ.';
        } else {
            $success = $this->accountModel->verifyEmail($token);
            $message = $success ? 'Xác thực email thành công. Bạn có thể đăng nhập ngay bây giờ.' : 'Liên kết xác thực không hợp lệ hoặc đã hết hạn.';
        }

        include 'app/views/account/verify.php';
    }

    public function forgot() {
        include 'app/views/account/forgot.php';
    }

    public function sendReset() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['email'] ?? '');
            $account = $this->accountModel->getAccountByUsername($username);
            if (!$account) {
                $error = "Không tìm thấy tài khoản.";
            } elseif ($account->is_locked) {
                $error = "Tài khoản đang bị khóa.";
            } else {
                $token = bin2hex(random_bytes(32));
                $expiresAt = date('Y-m-d H:i:s', time() + 3600);
                $this->accountModel->createResetToken($username, $token, $expiresAt);
                $sent = $this->sendPasswordResetEmail($username, $token);
                if ($sent) {
                    $success = "Một liên kết đặt lại mật khẩu đã được gửi tới email của bạn.";
                } else {
                    $success = "Liên kết đặt lại mật khẩu: " . $this->buildResetUrl($token);
                }
            }
        }

        include 'app/views/account/forgot.php';
    }

    public function reset($token = '') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            if (empty($token)) {
                $error = "Liên kết không hợp lệ.";
            } elseif (empty($password)) {
                $error = "Vui lòng nhập mật khẩu mới.";
            } elseif ($password !== $confirmPassword) {
                $error = "Mật khẩu mới và xác nhận không khớp.";
            } else {
                $account = $this->accountModel->getAccountByResetToken($token);
                if (!$account) {
                    $error = "Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.";
                } else {
                    $pattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/';
                    if (!preg_match($pattern, $password)) {
                        $error = "Mật khẩu phải từ 8 ký tự, có chữ in hoa, số và ký tự đặc biệt.";
                    } else {
                        $this->accountModel->updatePassword($account->username, $password);
                        $this->accountModel->clearResetToken($account->username);
                        $success = "Đặt lại mật khẩu thành công. Bạn có thể đăng nhập ngay bây giờ.";
                    }
                }
            }
            include 'app/views/account/reset.php';
            return;
        }

        // GET request - check if token is valid
        if (empty($token)) {
            $error = "Liên kết đặt lại mật khẩu không hợp lệ.";
        } else {
            $account = $this->accountModel->getAccountByResetToken($token);
            if (!$account) {
                $error = "Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.";
            }
        }

        include 'app/views/account/reset.php';
    }

    public function profile() {
        $this->requireLogin();
        $account = $this->accountModel->getAccountByUsername($_SESSION['username']);
        include 'app/views/account/profile.php';
    }

    public function updateprofile() {
        $this->requireLogin();
        $fullname = trim($_POST['fullname'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $avatar = null;

        if (empty($fullname)) {
            $error = "Vui lòng nhập họ tên.";
        } elseif (!empty($phone) && !preg_match('/^\+?[0-9]{9,15}$/', $phone)) {
            $error = "Số điện thoại không đúng định dạng.";
        } else {
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $avatar = $this->handleAvatarUpload($_FILES['avatar']);
            }

            if (!isset($error)) {
                $updated = $this->accountModel->updateProfile($_SESSION['username'], $fullname, $phone, $address, $avatar);
                if ($updated) {
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['address'] = $address;
                    if ($avatar) {
                        $_SESSION['avatar'] = $avatar;
                    }
                    $success = "Thông tin hồ sơ đã được cập nhật.";
                } else {
                    $error = "Cập nhật hồ sơ không thành công.";
                }
            }
        }

        $account = $this->accountModel->getAccountByUsername($_SESSION['username']);
        include 'app/views/account/profile.php';
    }

    public function changePassword() {
        $this->requireLogin();
        include 'app/views/account/change_password.php';
    }

    public function updatepassword() {
        $this->requireLogin();
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $account = $this->accountModel->getAccountByUsername($_SESSION['username']);

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $error = "Vui lòng điền đầy đủ thông tin.";
        } elseif (!password_verify($currentPassword, $account->password)) {
            $error = "Mật khẩu hiện tại không đúng.";
        } elseif ($newPassword !== $confirmPassword) {
            $error = "Mật khẩu mới và xác nhận không khớp.";
        } else {
            $pattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/';
            if (!preg_match($pattern, $newPassword)) {
                $error = "Mật khẩu phải từ 8 ký tự, có chữ in hoa, số và ký tự đặc biệt.";
            } else {
                $this->accountModel->updatePassword($_SESSION['username'], $newPassword);
                $success = "Đổi mật khẩu thành công.";
            }
        }

        include 'app/views/account/change_password.php';
    }

    public function users() {
        $this->requireAdmin();
        $users = $this->accountModel->getAllUsers();
        if (!is_array($users)) {
            $users = [];
        }
        include 'app/views/account/users.php';
    }

    public function lock($id) {
        $this->requireAdmin();
        $current = $_SESSION['username'] ?? '';
        $user = $this->accountModel->getAccountById($id);
        if ($user && $user->username !== $current) {
            $this->accountModel->setLockById($id, 1);
        }
        header('Location: /account/users');
        exit;
    }

    public function unlock($id) {
        $this->requireAdmin();
        $user = $this->accountModel->getAccountById($id);
        if ($user) {
            $this->accountModel->setLockById($id, 0);
        }
        header('Location: /account/users');
        exit;
    }

    private function handleAvatarUpload($file) {
        $targetDir = 'uploads/avatars/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            throw new Exception('File không phải là hình ảnh.');
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            throw new Exception('Ảnh đại diện không được quá 5MB.');
        }
        if (!in_array($imageFileType, $allowed)) {
            throw new Exception('Chỉ chấp nhận ảnh JPG, JPEG, PNG và GIF.');
        }
        $fileName = uniqid('avatar_', true) . '.' . $imageFileType;
        $targetPath = $targetDir . $fileName;
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new Exception('Có lỗi khi tải ảnh lên.');
        }
        return $targetPath;
    }

    private function buildVerificationUrl($token) {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        return $scheme . '://' . $_SERVER['HTTP_HOST'] . '/account/verify/' . $token;
    }

    private function buildResetUrl($token) {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        return $scheme . '://' . $_SERVER['HTTP_HOST'] . '/account/reset/' . $token;
    }

    private function sendVerificationEmail($email, $token) {
        $subject = 'Xác thực tài khoản tại KhanhzannShop';
        $verificationUrl = $this->buildVerificationUrl($token);
        $message = "Xin chào,\n\nVui lòng nhấp vào liên kết sau để xác thực tài khoản của bạn:\n" . $verificationUrl . "\n\nNếu bạn không đăng ký tài khoản này, hãy bỏ qua email.";
        $headers = 'From: no-reply@my_store.local' . "\r\n";
        return @mail($email, $subject, $message, $headers);
    }

    private function sendPasswordResetEmail($email, $token) {
        $subject = 'Đặt lại mật khẩu tại KhanhzannShop';
        $resetUrl = $this->buildResetUrl($token);
        $message = "Xin chào,\n\nNhấp vào liên kết dưới đây để đặt lại mật khẩu của bạn:\n" . $resetUrl . "\n\nLiên kết có hiệu lực trong 60 phút.";
        $headers = 'From: no-reply@my_store.local' . "\r\n";
        return @mail($email, $subject, $message, $headers);
    }
}
?>