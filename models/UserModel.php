<?php
require_once __DIR__ . '/../includes/db.php';

class UserModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT id, name, email, password, otp_code, is_verified, reset_token, reset_token_expiry FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createUser(string $name, string $email, string $passwordHash, string $otpCode)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, otp_code) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $passwordHash, $otpCode]);
    }

    public function updateVerification(int $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET is_verified = 1, otp_code = NULL WHERE id = ?");
        return $stmt->execute([$userId]);
    }

    public function updatePassword(int $userId, string $passwordHash)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$passwordHash, $userId]);
    }

    public function updateResetToken(int $userId, string $token, string $expiry)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE id = ?");
        return $stmt->execute([$token, $expiry, $userId]);
    }

    public function findByResetToken(string $token)
    {
        $stmt = $this->pdo->prepare("SELECT id, reset_token_expiry FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function updateProfile(int $userId, string $name, string $email)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $userId]);
    }

    public function isEmailUsedByOther(string $email, int $excludeUserId)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ? AND id <> ?");
        $stmt->execute([$email, $excludeUserId]);
        return $stmt->fetch() ? true : false;
    }
}
