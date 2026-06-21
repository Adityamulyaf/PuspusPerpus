<?php
/**
 * Category Controller for PuspusPerpus
 */

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    /**
     * List all categories and show creation form (combined view)
     */
    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        
        // Grab validation errors and old input values if redirected back from creation failure
        $errors = $_SESSION['errors'] ?? [];
        $old = $_SESSION['old'] ?? [];
        
        // Clean session temp variables
        unset($_SESSION['errors']);
        unset($_SESSION['old']);

        require_once __DIR__ . '/../views/categories/index.php';
    }

    /**
     * Create a category (POST only)
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=categories');
            exit;
        }

        // CSRF Verification
        $token = $_POST['csrf_token'] ?? '';
        if (!validateCsrfToken($token)) {
            setFlash('category_flash', 'Aksi dibatalkan. Token keamanan tidak valid.', 'danger');
            header('Location: index.php?route=categories');
            exit;
        }

        $name = sanitize($_POST['name'] ?? '');
        $errors = [];

        // Validation Rules
        if (empty($name)) {
            $errors[] = 'Nama kategori wajib diisi.';
        } elseif (strlen($name) < 3) {
            $errors[] = 'Nama kategori minimal harus 3 karakter.';
        } elseif ($this->categoryModel->isDuplicateCategory($name)) {
            $errors[] = 'Nama kategori "' . $name . '" sudah terdaftar.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['name' => $name];
            header('Location: index.php?route=categories');
            exit;
        }

        if ($this->categoryModel->createCategory($name)) {
            setFlash('category_flash', 'Kategori "' . $name . '" berhasil ditambahkan.', 'success');
        } else {
            setFlash('category_flash', 'Gagal menyimpan kategori ke database.', 'danger');
        }

        header('Location: index.php?route=categories');
        exit;
    }

    /**
     * Edit a specific category (GET and POST)
     */
    public function edit() {
        $id = sanitize($_GET['id'] ?? '');
        $category = $this->categoryModel->getCategoryById($id);

        if (!$category) {
            setFlash('category_flash', 'Kategori tidak ditemukan.', 'danger');
            header('Location: index.php?route=categories');
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Verification
            $token = $_POST['csrf_token'] ?? '';
            if (!validateCsrfToken($token)) {
                setFlash('category_flash', 'Aksi dibatalkan. Token keamanan tidak valid.', 'danger');
                header('Location: index.php?route=categories');
                exit;
            }

            $name = sanitize($_POST['name'] ?? '');

            // Validation Rules
            if (empty($name)) {
                $errors[] = 'Nama kategori wajib diisi.';
            } elseif (strlen($name) < 3) {
                $errors[] = 'Nama kategori minimal harus 3 karakter.';
            } elseif ($this->categoryModel->isDuplicateCategory($name, $id)) {
                $errors[] = 'Nama kategori "' . $name . '" sudah digunakan.';
            }

            if (empty($errors)) {
                if ($this->categoryModel->updateCategory($id, $name)) {
                    setFlash('category_flash', 'Kategori berhasil diperbarui menjadi "' . $name . '".', 'success');
                    header('Location: index.php?route=categories');
                    exit;
                } else {
                    $errors[] = 'Gagal menyimpan pembaruan ke database.';
                }
            }
        }

        require_once __DIR__ . '/../views/categories/edit.php';
    }

    /**
     * Delete a category (POST only)
     */
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=categories');
            exit;
        }

        // CSRF Verification
        $token = $_POST['csrf_token'] ?? '';
        if (!validateCsrfToken($token)) {
            setFlash('category_flash', 'Aksi dibatalkan. Token keamanan tidak valid.', 'danger');
            header('Location: index.php?route=categories');
            exit;
        }

        $id = sanitize($_POST['id'] ?? '');
        $category = $this->categoryModel->getCategoryById($id);

        if ($category && $this->categoryModel->deleteCategory($id)) {
            setFlash('category_flash', 'Kategori "' . $category['name'] . '" dan semua buku di dalamnya berhasil dihapus.', 'success');
        } else {
            setFlash('category_flash', 'Gagal menghapus kategori atau kategori tidak ditemukan.', 'danger');
        }

        header('Location: index.php?route=categories');
        exit;
    }
}
