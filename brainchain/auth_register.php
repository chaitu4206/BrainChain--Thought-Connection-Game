<?php
// auth_register.php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if ($username === "" || $password === "" || strlen($password) < 4) {
        $_SESSION["auth_error"] = "Username and password (min 4 chars) are required.";
        header("Location: login.php");
        exit();
    }

    // Check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION["auth_error"] = "Username already taken.";
        header("Location: login.php");
        exit();
    }
    $stmt->close();

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hash);
    if ($stmt->execute()) {
        $_SESSION["user_id"] = $stmt->insert_id;
        $_SESSION["username"] = $username;
        header("Location: game.php");
        exit();
    } else {
        $_SESSION["auth_error"] = "Error registering user.";
        header("Location: login.php");
        exit();
    }
}
header("Location: login.php");
