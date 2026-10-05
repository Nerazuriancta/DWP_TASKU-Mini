<?php
// Session database-backed agar tetap konsisten di deployment serverless seperti Vercel.
// Tetap menggunakan PHP session sehingga session_regenerate_id() dan CSRF berbasis session tetap berlaku.

if (session_status() === PHP_SESSION_ACTIVE) {
    return;
}

require_once __DIR__ . '/koneksi.php';

class TaskuSessionHandler implements SessionHandlerInterface
{
    private PDO $pdo;
    private int $ttl;

    public function __construct(PDO $pdo, int $ttl = 1440)
    {
        $this->pdo = $pdo;
        $this->ttl = $ttl;
    }

    public function open(string $path, string $name): bool { return true; }
    public function close(): bool { return true; }

    public function read(string $id): string
    {
        $stmt = $this->pdo->prepare(
            'SELECT data FROM tasku_sessions
             WHERE id = :id AND last_activity >= :cutoff'
        );
        $stmt->execute([
            'id' => $id,
            'cutoff' => time() - $this->ttl
        ]);
        $data = $stmt->fetchColumn();
        return $data === false ? '' : (string) $data;
    }

    public function write(string $id, string $data): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO tasku_sessions (id, data, last_activity)
             VALUES (:id, :data, :last_activity)
             ON CONFLICT (id) DO UPDATE SET
                 data = EXCLUDED.data,
                 last_activity = EXCLUDED.last_activity'
        );
        return $stmt->execute([
            'id' => $id,
            'data' => $data,
            'last_activity' => time()
        ]);
    }

    public function destroy(string $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM tasku_sessions WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function gc(int $max_lifetime): int|false
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM tasku_sessions WHERE last_activity < :cutoff'
        );
        $stmt->execute(['cutoff' => time() - $max_lifetime]);
        return $stmt->rowCount();
    }
}

// Membuat tabel otomatis agar tidak perlu langkah database tambahan saat deploy.
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS tasku_sessions (
        id VARCHAR(128) PRIMARY KEY,
        data TEXT NOT NULL,
        last_activity BIGINT NOT NULL
    )'
);

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', $secure ? '1' : '0');
ini_set('session.cookie_samesite', 'Lax');
session_name('TASKU_SESSION');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);

$handler = new TaskuSessionHandler($pdo);
session_set_save_handler($handler, true);
// Jangan izinkan browser/CDN menyimpan halaman yang bergantung pada session login.
header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

session_start();
