<?php
// api/leaderboard.php
require "../config.php";
require_login();

header("Content-Type: application/json");

$sql = "
  SELECT u.username, r.score, r.chain_length, r.creativity_percent, r.created_at
  FROM rounds r
  JOIN users u ON r.user_id = u.id
  ORDER BY r.score DESC
  LIMIT 10
";
$result = $conn->query($sql);
$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
echo json_encode(["success" => true, "leaderboard" => $rows]);
