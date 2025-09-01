<?php
// send_message.php
require 'db.php';
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) { echo json_encode(['success'=>false,'error'=>'not auth']); exit; }
$me = intval($_SESSION['user_id']);
$receiver = intval($_POST['receiver_id'] ?? 0);
$content = trim($_POST['content'] ?? '');
if (!$receiver || $content === '') { echo json_encode(['success'=>false,'error'=>'invalid']); exit; }
 
$stmt = $mysqli->prepare("INSERT INTO messages (sender_id, receiver_id, content, status) VALUES (?,?,?, 'sent')");
$stmt->bind_param('iis', $me, $receiver, $content);
if ($stmt->execute()) {
    echo json_encode(['success'=>true]);
} else echo json_encode(['success'=>false,'error'=>$mysqli->error]);
 
