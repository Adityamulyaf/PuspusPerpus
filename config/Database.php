<?php
/**
 * Database Connection class for PuspusPerpus
 * Uses PDO for secure, prepared-statement based operations.
 */

class Database {
    private static $host = 'localhost';
    private static $db_name = 'puspusperpus';
    private static $username = 'root';
    private static $password = '';
    private static $conn = null;

    /**
     * Establish database connection or return existing one (Singleton pattern)
     */
    public static function connect() {
        if (self::$conn === null) {
            try {
                // Initialize PDO connection
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4";
                self::$conn = new PDO($dsn, self::$username, self::$password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);

                // Auto seed admin user if users table exists and is empty
                self::autoSeedAdmin();

            } catch (PDOException $e) {
                // Display user-friendly database connection failure screen
                self::showConnectionError($e->getMessage());
                exit;
            }
        }
        return self::$conn;
    }

    /**
     * Auto seeds the default administrator account if the users table is empty
     */
    private static function autoSeedAdmin() {
        try {
            $stmt = self::$conn->query("SELECT COUNT(*) FROM users");
            $count = $stmt->fetchColumn();
            
            if ($count == 0) {
                $name = 'Admin PuspusPerpus';
                $email = 'admin@puspusperpus.com';
                $password_hash = password_hash('password123', PASSWORD_DEFAULT);

                $insert = self::$conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $insert->execute([$name, $email, $password_hash]);
            }
        } catch (PDOException $e) {
            // Table might not exist yet, we let the user know or import schema.sql
        }
    }

    /**
     * Show premium error page if database connection fails
     */
    private static function showConnectionError($message) {
        header("HTTP/1.1 500 Internal Server Error");
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Koneksi Database Gagal - PuspusPerpus</title>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
            <style>
                body {
                    font-family: 'Inter', sans-serif;
                    background-color: #F8FAFC;
                    color: #0F172A;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    min-height: 100vh;
                    margin: 0;
                    padding: 20px;
                }
                .card {
                    background: #FFFFFF;
                    border: 1px solid #E2E8F0;
                    border-radius: 12px;
                    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
                    max-width: 500px;
                    width: 100%;
                    padding: 32px;
                }
                .icon {
                    color: #EF4444;
                    margin-bottom: 20px;
                }
                h1 {
                    font-size: 20px;
                    font-weight: 700;
                    margin: 0 0 12px 0;
                }
                p {
                    color: #64748B;
                    font-size: 14px;
                    line-height: 1.6;
                    margin: 0 0 20px 0;
                }
                .error-box {
                    background-color: #FEF2F2;
                    border: 1px solid #FEE2E2;
                    border-radius: 6px;
                    padding: 12px;
                    font-family: monospace;
                    font-size: 12px;
                    color: #991B1B;
                    overflow-x: auto;
                    margin-bottom: 24px;
                }
                .btn {
                    display: inline-block;
                    background-color: #0F172A;
                    color: #FFFFFF;
                    padding: 10px 18px;
                    font-size: 14px;
                    font-weight: 500;
                    border-radius: 6px;
                    text-decoration: none;
                    transition: background-color 0.2s;
                }
                .btn:hover {
                    background-color: #1E293B;
                }
            </style>
        </head>
        <body>
            <div class="card">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 48px; height: 48px;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h1>Koneksi Database Gagal</h1>
                <p>Aplikasi tidak dapat terhubung ke server database MySQL. Pastikan database <strong>puspusperpus</strong> sudah dibuat dan server database lokal Anda (misalnya XAMPP) aktif.</p>
                <div class="error-box">
                    Error Detail: <?php echo htmlspecialchars($message); ?>
                </div>
                <p>Silakan buat database dengan nama <code>puspusperpus</code> dan import file <code>schema.sql</code> yang telah disediakan.</p>
                <a href="index.php" class="btn">Segarkan Halaman</a>
            </div>
        </body>
        </html>
        <?php
    }
}
