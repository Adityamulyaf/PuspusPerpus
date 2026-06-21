<?php
/**
 * Utility & Security Helper Functions for PuspusPerpus
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Clean & sanitize user input to prevent XSS
 */
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF Token for security
 */
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Output hidden input field with CSRF token
 */
function csrfField() {
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Validate CSRF Token
 */
function validateCsrfToken($token) {
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Set flash message to display after redirection
 */
function setFlash($key, $message, $type = 'success') {
    $_SESSION['flash'][$key] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Retrieve and clear flash message
 */
function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $flash = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $flash;
    }
    return null;
}

/**
 * Check if a flash message exists
 */
function hasFlash($key) {
    return isset($_SESSION['flash'][$key]);
}

/**
 * Check if user is authenticated
 */
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

/**
 * Restrict page access to logged in users only
 */
function requireAuth() {
    if (!isAuthenticated()) {
        header('Location: index.php?route=login');
        exit;
    }
}

/**
 * Highlight active page in sidebar/navigation
 */
function isRouteActive($routePattern) {
    $currentRoute = $_GET['route'] ?? 'dashboard';
    // Exact match for dashboard, prefix match for others (e.g. books/edit matches books)
    if ($routePattern === 'dashboard') {
        return $currentRoute === 'dashboard' ? 'active' : '';
    }
    return strpos($currentRoute, $routePattern) === 0 ? 'active' : '';
}
