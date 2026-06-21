<?php
/**
 * Book Model for PuspusPerpus
 */

class Book {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Get list of books with pagination and optional search filter
     */
    public function getAllBooks($search = '', $limit = 10, $offset = 0) {
        $sql = "SELECT b.*, c.name AS category_name 
                FROM books b 
                LEFT JOIN categories c ON b.category_id = c.id";
        
        if ($search !== '') {
            $sql .= " WHERE b.title LIKE :search 
                      OR b.author LIKE :search 
                      OR b.publisher LIKE :search 
                      OR c.name LIKE :search";
        }
        
        $sql .= " ORDER BY b.id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        
        if ($search !== '') {
            $searchTerm = '%' . $search . '%';
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        }
        
        // bind limit and offset as integers for proper MySQL execution
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get a specific book by ID
     */
    public function getBookById($id) {
        $stmt = $this->db->prepare("
            SELECT b.*, c.name AS category_name 
            FROM books b 
            LEFT JOIN categories c ON b.category_id = c.id 
            WHERE b.id = ? 
            LIMIT 1
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get total count of books, with optional search filter (used for pagination calculation)
     */
    public function getTotalBooks($search = '') {
        $sql = "SELECT COUNT(*) FROM books b LEFT JOIN categories c ON b.category_id = c.id";
        
        if ($search !== '') {
            $sql .= " WHERE b.title LIKE :search 
                      OR b.author LIKE :search 
                      OR b.publisher LIKE :search 
                      OR c.name LIKE :search";
        }

        $stmt = $this->db->prepare($sql);
        
        if ($search !== '') {
            $searchTerm = '%' . $search . '%';
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Get total number of books with 'Tersedia' (Available) status
     */
    public function getTotalAvailableBooks() {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM books WHERE status = 'Tersedia'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Add a new book to the library database
     */
    public function createBook($data) {
        $stmt = $this->db->prepare("
            INSERT INTO books (title, author, publisher, publication_year, category_id, status) 
            VALUES (:title, :author, :publisher, :publication_year, :category_id, :status)
        ");
        
        return $stmt->execute([
            ':title' => $data['title'],
            ':author' => $data['author'],
            ':publisher' => $data['publisher'],
            ':publication_year' => $data['publication_year'],
            ':category_id' => $data['category_id'],
            ':status' => $data['status']
        ]);
    }

    /**
     * Update an existing book's details
     */
    public function updateBook($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE books 
            SET title = :title, 
                author = :author, 
                publisher = :publisher, 
                publication_year = :publication_year, 
                category_id = :category_id, 
                status = :status 
            WHERE id = :id
        ");
        
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':author' => $data['author'],
            ':publisher' => $data['publisher'],
            ':publication_year' => $data['publication_year'],
            ':category_id' => $data['category_id'],
            ':status' => $data['status']
        ]);
    }

    /**
     * Delete a book from the library database
     */
    public function deleteBook($id) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
