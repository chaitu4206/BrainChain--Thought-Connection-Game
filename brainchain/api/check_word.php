<?php
// api/check_word.php
require "../config.php";
require_login();

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$currentWord = strtolower(trim($data["currentWord"] ?? ""));
$inputWord   = strtolower(trim($data["inputWord"] ?? ""));

if ($currentWord === "" || $inputWord === "") {
    echo json_encode(["success" => false, "error" => "Missing words"]);
    exit();
}

// Check relation exists
$sql = "
    SELECT r.id
    FROM relations r
    JOIN words w1 ON r.from_word_id = w1.id
    JOIN words w2 ON r.to_word_id = w2.id
    WHERE w1.text = ? AND w2.text = ?
    LIMIT 1
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $currentWord, $inputWord);
$stmt->execute();
$stmt->store_result();
$valid = $stmt->num_rows > 0;
$stmt->close();

// Determine next prompt word
$nextWord = null;
$stmt = $conn->prepare("SELECT text FROM words WHERE text = ? LIMIT 1");
$stmt->bind_param("s", $inputWord);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $nextWord = $row["text"];
} else {
    $sql2 = "SELECT text FROM words ORDER BY RAND() LIMIT 1";
    $r2 = $conn->query($sql2);
    if ($rw2 = $r2->fetch_assoc()) {
        $nextWord = $rw2["text"];
    }
}
$stmt->close();

echo json_encode([
    "success" => true,
    "valid"   => $valid,
    "nextWord"=> $nextWord
]);
