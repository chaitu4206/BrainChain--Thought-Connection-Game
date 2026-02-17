<?php
// config.php — improved

// Prefer explicit cookie params before session_start()
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$httponly = true;
$samesite = 'Lax'; // or 'Strict' depending on UX

// PHP < 7.3 fallback handling for samesite (use session_set_cookie_params with array on 7.3+)
if (PHP_VERSION_ID >= 70300) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $secure,
        'httponly' => $httponly,
        'samesite' => $samesite
    ]);
} else {
    // best-effort for older PHP
    ini_set('session.cookie_lifetime', 0);
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_secure', $secure ? 1 : 0);
    ini_set('session.cookie_httponly', $httponly ? 1 : 0);
}

ini_set('session.use_strict_mode', 1);

session_start();

// DB credentials: prefer environment variables (fallback to hardcoded — move to .env in production)
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: '23CS156';
$password = getenv('DB_PASS') ?: 'Harsha@4304';
$db   = getenv('DB_NAME') ?: 'brainchain_db';

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    // Log details for ops, show generic message to user
    error_log("DB connection failed: " . $conn->connect_error);
    // For API requests return JSON 500, else a generic HTML page
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    $isApi = (str_starts_with($uri, '/api/') || strpos($accept, 'application/json') !== false);
    if ($isApi) {
        header('Content-Type: application/json', true, 500);
        echo json_encode(['success' => false, 'error' => 'Service unavailable']);
    } else {
        http_response_code(500);
        echo "Service temporarily unavailable.";
    }
    exit();
}

$conn->set_charset("utf8mb4");

// Helper JSON responses for APIs
function json_error($msg, $code = 400) {
    header('Content-Type: application/json', true, $code);
    echo json_encode(['success' => false, 'error' => $msg]);
    exit();
}
function json_ok($data = []) {
    header('Content-Type: application/json', true, 200);
    echo json_encode(array_merge(['success' => true], $data));
    exit();
}

// login requirement aware of API vs normal pages
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';

        // Treat as API if path contains /api/ or Accept header requests JSON
        $isApi = (str_starts_with($uri, '/api/') || strpos($accept, 'application/json') !== false);

        if ($isApi) {
            header('Content-Type: application/json', true, 401);
            echo json_encode(['success' => false, 'error' => 'Authentication required']);
            exit();
        }

        header("Location: login.php");
        exit();
    }
}
