<?php
// api/start_word.php
require "../config.php";
require_login();

header("Content-Type: application/json");

$sql = "SELECT text FROM words ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
    echo json_encode(["success" => true, "word" => $row["text"]]);
} else {
    echo json_encode(["success" => false, "error" => "No words in database"]);
}
