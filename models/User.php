<?php
/**
 * User Model for PuspusPerpus
 */

class User {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Authenticate user with email and password
     * Uses password_verify() for secure authentication.
     */
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Store details in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            return $user;
        }
        return false;
    }

    /**
     * Log out current user and regenerate session
     */
    public function logout() {
        // Clear session variables
        $_SESSION = [];

        // Destroy session cookie if set
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy session
        session_destroy();
        
        // Start a fresh session to allow flash messages or new CSRF tokens
        session_start();
    }
}
