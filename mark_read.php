<?php
// mark_read.php
require 'db.php';
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) { echo json_encode(['success'=>false]); exit; }
$me = intval($_SESSION['user_id']);
$other = intval($_GET['with'] ?? 0);
$upd = $mysqli->prepare("UPDATE messages SET status='read' WHERE sender_id = ? AND receiver_id = ? AND status != 'read'");
$upd->bind_param('ii', $other, $me);
$upd->execute();
echo json_encode(['success'=>true]);
 
