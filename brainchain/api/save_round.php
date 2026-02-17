<?php
// api/save_round.php
require "../config.php";
require_login();

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$score            = $data["score"] ?? null;
$chainLength      = $data["chainLength"] ?? null;
$creativityPercent= $data["creativityPercent"] ?? null;

if ($score === null || $chainLength === null || $creativityPercent === null) {
    echo json_encode(["success" => false, "error" => "Missing fields"]);
    exit();
}

$userId = $_SESSION["user_id"];

$sql = "INSERT INTO rounds (user_id, score, chain_length, creativity_percent)
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $userId, $score, $chainLength, $creativityPercent);
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Round saved"]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to save round"]);
}
$stmt->close();
