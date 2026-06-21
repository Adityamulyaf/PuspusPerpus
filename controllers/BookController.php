<?php
/**
 * Book Controller for PuspusPerpus
 */

class BookController {
    private $bookModel;
    private $categoryModel;

    public function __construct() {
        $this->bookModel = new Book();
        $this->categoryModel = new Category();
    }

    /**
     * List books with search and pagination
     */
    public function index() {
        $search = sanitize($_GET['search'] ?? '');
        
        // Pagination logic
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        
        $limit = 5; // Display 5 books per page to make pagination easily testable
        $totalBooks = $this->bookModel->getTotalBooks($search);
        $totalPages = ceil($totalBooks / $limit);
        
        if ($totalPages < 1) {
            $totalPages = 1;
        }
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        
        $offset = ($page - 1) * $limit;
        $books = $this->bookModel->getAllBooks($search, $limit, $offset);

        require_once __DIR__ . '/../views/books/index.php';
    }

    /**
     * Display dashboard with overall library statistics
     */
    public function dashboard() {
        $totalBooks = $this->bookModel->getTotalBooks();
        $totalCategories = $this->categoryModel->getTotalCategories();
        $totalAvailable = $this->bookModel->getTotalAvailableBooks();

        require_once __DIR__ . '/../views/dashboard.php';
    }

    /**
     * Add a new book
     */
    public function create() {
        $categories = $this->categoryModel->getAllCategories();
        $errors = [];
        $old = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Verification
            $token = $_POST['csrf_token'] ?? '';
            if (!validateCsrfToken($token)) {
                $errors['auth'] = 'Aksi dibatalkan. Token keamanan tidak valid.';
            } else {
                $title = sanitize($_POST['title'] ?? '');
                $author = sanitize($_POST['author'] ?? '');
                $publisher = sanitize($_POST['publisher'] ?? '');
                $publication_year = sanitize($_POST['publication_year'] ?? '');
                $category_id = sanitize($_POST['category_id'] ?? '');
                $status = sanitize($_POST['status'] ?? 'Tersedia');

                // Keep old values in case of validation failure
                $old = [
                    'title' => $title,
                    'author' => $author,
                    'publisher' => $publisher,
                    'publication_year' => $publication_year,
                    'category_id' => $category_id,
                    'status' => $status
                ];

                // Server-side Validation Rules
                if (empty($title)) {
                    $errors['title'] = 'Judul buku wajib diisi.';
                } elseif (strlen($title) < 3) {
                    $errors['title'] = 'Judul buku minimal harus 3 karakter.';
                }

                if (empty($author)) {
                    $errors['author'] = 'Penulis wajib diisi.';
                } elseif (strlen($author) < 3) {
                    $errors['author'] = 'Nama penulis minimal harus 3 karakter.';
                }

                if (empty($publisher)) {
                    $errors['publisher'] = 'Penerbit wajib diisi.';
                }

                $currentYear = (int)date('Y');
                if (empty($publication_year)) {
                    $errors['publication_year'] = 'Tahun terbit wajib diisi.';
                } elseif (!is_numeric($publication_year)) {
                    $errors['publication_year'] = 'Tahun terbit harus berupa angka.';
                } else {
                    $yearInt = (int)$publication_year;
                    if ($yearInt < 1900 || $yearInt > $currentYear) {
                        $errors['publication_year'] = "Tahun terbit harus antara 1900 hingga {$currentYear}.";
                    }
                }

                if (empty($category_id)) {
                    $errors['category_id'] = 'Kategori wajib dipilih.';
                }

                if (!in_array($status, ['Tersedia', 'Dipinjam'])) {
                    $errors['status'] = 'Status tidak valid.';
                }

                // If validation passed, save the book
                if (empty($errors)) {
                    $saveData = [
                        'title' => $title,
                        'author' => $author,
                        'publisher' => $publisher,
                        'publication_year' => (int)$publication_year,
                        'category_id' => (int)$category_id,
                        'status' => $status
                    ];

                    if ($this->bookModel->createBook($saveData)) {
                        setFlash('book_flash', "Buku \"{$title}\" berhasil ditambahkan.", 'success');
                        header('Location: index.php?route=books');
                        exit;
                    } else {
                        $errors['db'] = 'Gagal menyimpan buku ke database.';
                    }
                }
            }
        }

        require_once __DIR__ . '/../views/books/create.php';
    }

    /**
     * Edit a specific book's details
     */
    public function edit() {
        $id = sanitize($_GET['id'] ?? '');
        $book = $this->bookModel->getBookById($id);

        if (!$book) {
            setFlash('book_flash', 'Buku tidak ditemukan.', 'danger');
            header('Location: index.php?route=books');
            exit;
        }

        $categories = $this->categoryModel->getAllCategories();
        $errors = [];
        $old = [
            'title' => $book['title'],
            'author' => $book['author'],
            'publisher' => $book['publisher'],
            'publication_year' => $book['publication_year'],
            'category_id' => $book['category_id'],
            'status' => $book['status']
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Verification
            $token = $_POST['csrf_token'] ?? '';
            if (!validateCsrfToken($token)) {
                $errors['auth'] = 'Aksi dibatalkan. Token keamanan tidak valid.';
            } else {
                $title = sanitize($_POST['title'] ?? '');
                $author = sanitize($_POST['author'] ?? '');
                $publisher = sanitize($_POST['publisher'] ?? '');
                $publication_year = sanitize($_POST['publication_year'] ?? '');
                $category_id = sanitize($_POST['category_id'] ?? '');
                $status = sanitize($_POST['status'] ?? 'Tersedia');

                // Overwrite old array with latest submissions
                $old = [
                    'title' => $title,
                    'author' => $author,
                    'publisher' => $publisher,
                    'publication_year' => $publication_year,
                    'category_id' => $category_id,
                    'status' => $status
                ];

                // Validation Rules
                if (empty($title)) {
                    $errors['title'] = 'Judul buku wajib diisi.';
                } elseif (strlen($title) < 3) {
                    $errors['title'] = 'Judul buku minimal harus 3 karakter.';
                }

                if (empty($author)) {
                    $errors['author'] = 'Penulis wajib diisi.';
                } elseif (strlen($author) < 3) {
                    $errors['author'] = 'Nama penulis minimal harus 3 karakter.';
                }

                if (empty($publisher)) {
                    $errors['publisher'] = 'Penerbit wajib diisi.';
                }

                $currentYear = (int)date('Y');
                if (empty($publication_year)) {
                    $errors['publication_year'] = 'Tahun terbit wajib diisi.';
                } elseif (!is_numeric($publication_year)) {
                    $errors['publication_year'] = 'Tahun terbit harus berupa angka.';
                } else {
                    $yearInt = (int)$publication_year;
                    if ($yearInt < 1900 || $yearInt > $currentYear) {
                        $errors['publication_year'] = "Tahun terbit harus antara 1900 hingga {$currentYear}.";
                    }
                }

                if (empty($category_id)) {
                    $errors['category_id'] = 'Kategori wajib dipilih.';
                }

                if (!in_array($status, ['Tersedia', 'Dipinjam'])) {
                    $errors['status'] = 'Status tidak valid.';
                }

                // If validation passed, update the book
                if (empty($errors)) {
                    $updateData = [
                        'title' => $title,
                        'author' => $author,
                        'publisher' => $publisher,
                        'publication_year' => (int)$publication_year,
                        'category_id' => (int)$category_id,
                        'status' => $status
                    ];

                    if ($this->bookModel->updateBook($id, $updateData)) {
                        setFlash('book_flash', "Buku \"{$title}\" berhasil diperbarui.", 'success');
                        header('Location: index.php?route=books');
                        exit;
                    } else {
                        $errors['db'] = 'Gagal menyimpan perubahan ke database.';
                    }
                }
            }
        }

        require_once __DIR__ . '/../views/books/edit.php';
    }

    /**
     * Delete a specific book (POST only)
     */
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=books');
            exit;
        }

        // CSRF Verification
        $token = $_POST['csrf_token'] ?? '';
        if (!validateCsrfToken($token)) {
            setFlash('book_flash', 'Aksi dibatalkan. Token keamanan tidak valid.', 'danger');
            header('Location: index.php?route=books');
            exit;
        }

        $id = sanitize($_POST['id'] ?? '');
        $book = $this->bookModel->getBookById($id);

        if ($book && $this->bookModel->deleteBook($id)) {
            setFlash('book_flash', "Buku \"{$book['title']}\" berhasil dihapus.", 'success');
        } else {
            setFlash('book_flash', 'Gagal menghapus buku atau data tidak ditemukan.', 'danger');
        }

        header('Location: index.php?route=books');
        exit;
    }
}
