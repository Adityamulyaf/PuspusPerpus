<?php
/**
 * Auth Controller for PuspusPerpus
 */

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Handle Admin Login
     */
    public function login() {
        // If already logged in, skip login page and go to dashboard
        if (isAuthenticated()) {
            header('Location: index.php?route=dashboard');
            exit;
        }

        $errors = [];
        $old = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF
            $token = $_POST['csrf_token'] ?? '';
            if (!validateCsrfToken($token)) {
                $errors['auth'] = 'Keamanan terganggu (CSRF token tidak valid). Silakan coba lagi.';
            } else {
                $email = sanitize($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                $old['email'] = $email;

                // Validation Rules
                if (empty($email)) {
                    $errors['email'] = 'Email wajib diisi.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Format email tidak valid.';
                }

                if (empty($password)) {
                    $errors['password'] = 'Password wajib diisi.';
                } elseif (strlen($password) < 6) {
                    $errors['password'] = 'Password minimal harus 6 karakter.';
                }

                // If validation passed, attempt log in
                if (empty($errors)) {
                    $user = $this->userModel->login($email, $password);
                    if ($user) {
                        setFlash('success', 'Selamat datang kembali, ' . $user['name'] . '!');
                        header('Location: index.php?route=dashboard');
                        exit;
                    } else {
                        $errors['auth'] = 'Email atau password salah.';
                    }
                }
            }
        }

        // Render Login page
        require_once __DIR__ . '/../views/login.php';
    }

    /**
     * Handle Admin Logout
     */
    public function logout() {
        $this->userModel->logout();
        setFlash('success', 'Anda telah berhasil keluar dari sistem.', 'info');
        header('Location: index.php?route=login');
        exit;
    }
}
