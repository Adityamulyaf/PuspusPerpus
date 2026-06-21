<?php
/**
 * PuspusPerpus - Library Book Management Web Application
 * Main Entry Point (Front Controller) & Router
 */

// 1. Load configuration and helper modules
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/config/helpers.php';

// 2. Load data models
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Book.php';
require_once __DIR__ . '/models/Category.php';

// 3. Load logic controllers
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/BookController.php';
require_once __DIR__ . '/controllers/CategoryController.php';

// 4. Resolve the route parameter
$route = $_GET['route'] ?? 'dashboard';

// 5. Enforce Authentication (redirect unauthenticated requests to login page)
if (!isAuthenticated() && $route !== 'login') {
    header('Location: index.php?route=login');
    exit;
}

// 6. Router mappings switchboard
switch ($route) {
    // --- Authentication Routes ---
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    // --- Dashboard Summary ---
    case 'dashboard':
        $controller = new BookController();
        $controller->dashboard();
        break;

    // --- Book Entity Management (CRUD) ---
    case 'books':
        $controller = new BookController();
        $controller->index();
        break;

    case 'books/create':
        $controller = new BookController();
        $controller->create();
        break;

    case 'books/edit':
        $controller = new BookController();
        $controller->edit();
        break;

    case 'books/delete':
        $controller = new BookController();
        $controller->delete();
        break;

    // --- Category Entity Management (CRUD) ---
    case 'categories':
        $controller = new CategoryController();
        $controller->index();
        break;

    case 'categories/create':
        $controller = new CategoryController();
        $controller->create();
        break;

    case 'categories/edit':
        $controller = new CategoryController();
        $controller->edit();
        break;

    case 'categories/delete':
        $controller = new CategoryController();
        $controller->delete();
        break;

    // --- 404 Fallback Page ---
    default:
        http_response_code(404);
        $pageTitle = 'Halaman Tidak Ditemukan';
        require_once __DIR__ . '/partials/header.php';
        ?>
        <div style="text-align: center; padding: 80px 24px;">
            <div style="color: var(--muted-foreground); margin-bottom: 24px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 64px; height: 64px; margin: 0 auto;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                </svg>
            </div>
            <h2 style="font-size: 24px; font-weight: 700; color: var(--primary); margin-bottom: 8px;">404 - Halaman Tidak Ditemukan</h2>
            <p style="color: var(--muted-foreground); font-size: 14px; margin-bottom: 24px;">Maaf, halaman yang Anda minta tidak terdaftar atau telah dihapus.</p>
            <a href="index.php?route=dashboard" class="btn btn-primary btn-sm">Kembali ke Dashboard</a>
        </div>
        <?php
        require_once __DIR__ . '/partials/footer.php';
        break;
}
