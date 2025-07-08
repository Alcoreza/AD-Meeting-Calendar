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
        echo "🔍 Login using DB: {$pgConfig['dbname']}<br>";

        $dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
        $pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);


        $tables = $pdo->query("SELECT schemaname, tablename FROM pg_tables WHERE tablename ILIKE '%users%'")->fetchAll(PDO::FETCH_ASSOC);
        echo "<hr><strong>📋 Available user-like tables:</strong><pre>";
        print_r($tables);
        echo "</pre>";

        $pdo->exec("SET search_path TO public");

        echo "Connected as user: " . $pdo->query("SELECT current_user")->fetchColumn() . "<br>";


        // ✅ ADD THE DEBUG HERE
        echo "<hr><strong>🧪 Running raw SELECT to check usernames:</strong><br>";
        $allUsers = $pdo->query("SELECT username FROM public.\"users\"")->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        print_r($allUsers);
        echo "</pre>";

        // Also show what we're searching for
        echo "Trying to find username: '$username'<br>";

        // Optional: trim the input
        $username = trim($username);

        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM public.\"users\" WHERE LOWER(username) = LOWER(:username)");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<hr><strong>Running full user dump from DB:</strong><br>";
        $dump = $pdo->query('SELECT * FROM public."users"')->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        print_r($dump);
        echo "</pre>";


        echo "Entered username: $username<br>";
        echo "Entered password: $password<br>";
        echo "User from DB:<br><pre>";
        print_r($user);
        echo "</pre>";

        if ($user) {
            if (password_verify($password, $user['password'])) {
                echo "✅ password_verify PASSED<br>";
            } else {
                echo "❌ password_verify FAILED<br>";
            }
        } else {
            echo "❌ User not found<br>";
        }

        exit; // stop script after debug output
        // 🔍 DEBUG END

        // If user found and password matches
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false; // failed login
    }
}
