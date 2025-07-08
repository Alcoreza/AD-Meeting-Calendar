<?php
class Auth
{
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function check(): bool
    {
        self::init();
        return isset($_SESSION['user']);
    }

    public static function user(): ?array
    {
        self::init();
        return $_SESSION['user'] ?? null;
    }

    public static function logout(): void
    {
        self::init();
        session_destroy();
        setcookie(session_name(), '', time() - 3600);
    }

    public static function login(string $username, string $password): bool
    {
        self::init();

        require BOOTSTRAP_PATH;
        require_once UTILS_PATH . 'envSetter.util.php';
        global $pgConfig;

        $dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
        $pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $pdo->exec("SET search_path TO public");

        $username = trim($username);

        $stmt = $pdo->prepare("SELECT * FROM public.\"users\" WHERE LOWER(username) = LOWER(:username)");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }
}
