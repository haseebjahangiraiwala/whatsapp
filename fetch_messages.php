<?php
// fetch_messages.php
require 'db.php';
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) { echo json_encode([]); exit; }
$me = intval($_SESSION['user_id']);
$other = intval($_GET['with'] ?? 0);
 
// mark messages sent to me as delivered (if they were 'sent')
$upd = $mysqli->prepare("UPDATE messages SET status='delivered' WHERE sender_id = ? AND receiver_id = ? AND status = 'sent'");
$upd->bind_param('ii', $other, $me);
$upd->execute();
 
// fetch last 200 messages in conversation
$stmt = $mysqli->prepare("
  SELECT id, sender_id, receiver_id, content, status, created_at
  FROM messages
  WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
  ORDER BY created_at ASC
  LIMIT 200
");
$stmt->bind_param('iiii',$me,$other,$other,$me);
$stmt->execute();
$res = $stmt->get_result();
$out = [];
while($r = $res->fetch_assoc()){
    $out[] = [
      'id'=>$r['id'],
      'sender_id'=>$r['sender_id'],
      'receiver_id'=>$r['receiver_id'],
      'content'=>$r['content'],
      'status'=>$r['status'],
      'created_at'=>date('M d H:i', strtotime($r['created_at']))
    ];
}
echo json_encode($out);
 
