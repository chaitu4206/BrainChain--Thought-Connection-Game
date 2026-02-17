<?php
// auth_login.php
require __DIR__ . "/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit();
}

$username = trim($_POST["username"] ?? "");
$password = trim($_POST["password"] ?? "");

// Basic validation
if ($username === "" || $password === "") {
    $_SESSION["auth_error"] = "Please enter username and password.";
    header("Location: login.php");
    exit();
}

// Simple brute-force protection (per-session). For stronger protection use Redis or DB.
$maxAttempts = 5;
$lockoutSeconds = 15 * 60; // 15 minutes

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['login_blocked_until'] = 0;
}

$now = time();
if (!empty($_SESSION['login_blocked_until']) && $now < $_SESSION['login_blocked_until']) {
    $remaining = $_SESSION['login_blocked_until'] - $now;
    $_SESSION["auth_error"] = "Too many attempts. Try again in " . ceil($remaining/60) . " minute(s).";
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = ? LIMIT 1");
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    $_SESSION["auth_error"] = "Internal error. Try again later.";
    header("Location: login.php");
    exit();
}
$normalizedUsername = mb_strtolower($username, 'UTF-8');
$stmt->bind_param("s", $normalizedUsername);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $hash);

if ($stmt->num_rows === 1 && $stmt->fetch()) {
    if (password_verify($password, $hash)) {
        // Successful login
        session_regenerate_id(true);
        $_SESSION["user_id"] = $id;
        $_SESSION["username"] = $normalizedUsername;
        // Reset counters
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_blocked_until'] = 0;
        $stmt->close();
        header("Location: game.php");
        exit();
    }
}

// Failed login path
$_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
if ($_SESSION['login_attempts'] >= $maxAttempts) {
    $_SESSION['login_blocked_until'] = time() + $lockoutSeconds;
}
$_SESSION["auth_error"] = "Invalid username or password.";
$stmt->close();

header("Location: login.php");
exit();
