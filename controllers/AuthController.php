<?php
require_once __DIR__ . '/../models/UserModel.php';
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        $errors = [];
        $data = ['name' => '', 'email' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['name']  = trim($_POST['name'] ?? '');
            $data['email'] = trim($_POST['email'] ?? '');
            $password      = $_POST['password'] ?? '';
            $confirm       = $_POST['confirm'] ?? '';

            // Validate dữ liệu
            if ($data['name'] === '') $errors[] = "Tên không được để trống.";
            if ($data['email'] === '') $errors[] = "Email không được để trống.";
            elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Email không hợp lệ.";
            if ($password === '') $errors[] = "Mật khẩu không được để trống.";
            elseif (strlen($password) < 6) $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
            if ($password !== $confirm) $errors[] = "Mật khẩu xác nhận không khớp.";

            if (empty($errors)) {
                try {
                    if ($this->userModel->findByEmail($data['email'])) {
                        $errors[] = "Email đã được sử dụng.";
                    } else {
                        $hash = password_hash($password, PASSWORD_BCRYPT);
                        $otp  = random_int(100000, 999999);

                        $this->userModel->createUser($data['name'], $data['email'], $hash, $otp);

                        // Gửi mail OTP
                        $this->sendOTPEmail($data['email'], $data['name'], $otp);

                        header("Location: ?controller=auth&action=verify&email=" . urlencode($data['email']));
                        exit;
                    }
                } catch (Exception $e) {
                    $errors[] = "Lỗi máy chủ, vui lòng thử lại sau.";
                    error_log($e->getMessage());
                }
            }
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    private function sendOTPEmail(string $email, string $name, int $otp)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'daidzpro82@gmail.com';
            $mail->Password   = 'rrvipptgxxgavgzz';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('daidzpro82@gmail.com', 'GShoes Shop');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Mã xác nhận tài khoản GShoes Shop';
            $mail->Body    = "Xin chào <strong>{$name}</strong>,<br><br>"
                . "Mã xác nhận tài khoản của bạn là:<br>"
                . "<h2 style=\"letter-spacing:3px;\">{$otp}</h2>"
                . "Vui lòng nhập mã này trên trang xác nhận để kích hoạt tài khoản.<br><br>"
                . "— GShoes Shop —";

            $mail->send();
        } catch (Exception $e) {
            error_log('Mail error: ' . $mail->ErrorInfo);
        }
    }

    public function verify()
    {
        $email  = $_GET['email'] ?? '';
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $otp   = trim($_POST['otp'] ?? '');

            if ($email === '' || $otp === '') {
                $errors[] = "Vui lòng nhập đầy đủ email và mã OTP.";
            } else {
                $user = $this->userModel->findByEmail($email);

                if (!$user) {
                    $errors[] = "Email không tồn tại.";
                } elseif ($user['is_verified']) {
                    $errors[] = "Tài khoản đã được xác minh.";
                } elseif ($user['otp_code'] !== $otp) {
                    $errors[] = "Mã OTP không đúng.";
                } else {
                    $this->userModel->updateVerification($user['id']);
                    header("Location: ?controller=auth&action=login&verified=1");
                    exit;
                }
            }
        }

        require __DIR__ . '/../views/auth/verify.php';
    }

    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = "Vui lòng nhập email và mật khẩu.";
            } else {
                $user = $this->userModel->findByEmail($email);

                if (!$user) {
                    $error = "Email hoặc mật khẩu không đúng.";
                } elseif (!password_verify($password, $user['password'])) {
                    $error = "Email hoặc mật khẩu không đúng.";
                } elseif (!$user['is_verified']) {
                    $error = "Tài khoản chưa xác minh, vui lòng kiểm tra email.";
                } else {
                    session_regenerate_id(true);
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email']
                    ];
                    header("Location: index.php");
                    exit;
                }
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function changePassword()
    {
        if (empty($_SESSION['user'])) {
            header("Location: ?controller=auth&action=login");
            exit;
        }

        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current = $_POST['current_password'] ?? '';
            $new = $_POST['new_password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if (!$current || !$new || !$confirm) {
                $errors[] = "Vui lòng nhập đầy đủ thông tin.";
            } elseif ($new !== $confirm) {
                $errors[] = "Mật khẩu mới và xác nhận không khớp.";
            } elseif (strlen($new) < 6) {
                $errors[] = "Mật khẩu mới phải ít nhất 6 ký tự.";
            } else {
                $user = $this->userModel->findById($_SESSION['user']['id']);

                if (!$user || !password_verify($current, $user['password'])) {
                    $errors[] = "Mật khẩu hiện tại không đúng.";
                } else {
                    $hash = password_hash($new, PASSWORD_BCRYPT);
                    $this->userModel->updatePassword($_SESSION['user']['id'], $hash);
                    $success = true;
                }
            }
        }

        require __DIR__ . '/../views/auth/change_password.php';
    }

    public function forgotPassword()
    {
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            if (!$email) {
                $errors[] = "Vui lòng nhập email.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ.";
            } else {
                $user = $this->userModel->findByEmail($email);

                if ($user) {
                    $token = bin2hex(random_bytes(16));
                    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    $this->userModel->updateResetToken($user['id'], $token, $expiry);

                    // Gửi mail đặt lại mật khẩu
                    $this->sendResetPasswordEmail($email, $user['name'], $token);
                }
                // Không tiết lộ email có tồn tại hay không
                $success = true;
            }
        }

        require __DIR__ . '/../views/auth/forgot_password.php';
    }

    private function sendResetPasswordEmail(string $email, string $name, string $token)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'daidzpro82@gmail.com';
            $mail->Password   = 'rrvipptgxxgavgzz';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('daidzpro82@gmail.com', 'GShoes Shop');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Yêu cầu đặt lại mật khẩu GShoes Shop';
            $link = "http://localhost/GShoes_Shop?controller=auth&action=resetPassword&token=$token";
            $mail->Body = "Chào {$name},<br><br>"
                . "Bạn hoặc ai đó đã yêu cầu đặt lại mật khẩu cho tài khoản của bạn.<br>"
                . "Vui lòng nhấn vào link bên dưới để đặt mật khẩu mới:<br>"
                . "<a href=\"$link\">$link</a><br><br>"
                . "Nếu không phải bạn, hãy bỏ qua email này.<br><br>— GShoes Shop";

            $mail->send();
        } catch (Exception $e) {
            error_log('Mail error: ' . $mail->ErrorInfo);
        }
    }

    public function resetPassword()
    {
        $errors = [];
        $success = false;

        $token = $_GET['token'] ?? '';

        if (!$token) {
            die('Liên kết không hợp lệ.');
        }

        $user = $this->userModel->findByResetToken($token);

        if (!$user || strtotime($user['reset_token_expiry']) < time()) {
            die('Liên kết đã hết hạn hoặc không hợp lệ.');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new = $_POST['new_password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if (!$new || !$confirm) {
                $errors[] = "Vui lòng nhập đầy đủ thông tin.";
            } elseif ($new !== $confirm) {
                $errors[] = "Mật khẩu xác nhận không khớp.";
            } elseif (strlen($new) < 6) {
                $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
            } else {
                $hash = password_hash($new, PASSWORD_BCRYPT);
                $stmt = $this->userModel->updatePassword($user['id'], $hash);
                // Xóa token sau khi đổi mật khẩu thành công
                $pdo = getPDO();
                $pdo->prepare("UPDATE users SET reset_token = NULL, reset_token_expiry = NULL WHERE id = ?")->execute([$user['id']]);

                $success = true;
            }
        }

        require __DIR__ . '/../views/auth/reset_password.php';
    }

    public function profile()
    {
        if (empty($_SESSION['user'])) {
            header("Location: ?controller=auth&action=login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $errors = [];
        $success = false;

        $user = $this->userModel->findById($userId);

        if (!$user) {
            echo "Người dùng không tồn tại";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if ($name === '') {
                $errors[] = "Tên không được để trống.";
            }

            if ($email === '') {
                $errors[] = "Email không được để trống.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ.";
            } elseif ($this->userModel->isEmailUsedByOther($email, $userId)) {
                $errors[] = "Email đã được sử dụng bởi người khác.";
            }

            if (empty($errors)) {
                $this->userModel->updateProfile($userId, $name, $email);

                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;

                $success = true;
                $user['name'] = $name;
                $user['email'] = $email;
            }
        }

        require __DIR__ . '/../views/auth/profile.php';
    }

    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();

        header("Location: ?controller=auth&action=login");
        exit;
    }
}
