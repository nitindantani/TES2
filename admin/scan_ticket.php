<?php
header('Content-Type: application/json');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD']!=='POST') {
  echo json_encode(['success'=>false,'error'=>'must POST']); exit;
}
$code = trim($_POST['code'] ?? '');
if (!$code) {
  echo json_encode(['success'=>false,'error'=>'empty code']); exit;
}

// connect
$bk = new mysqli('localhost','root','','touristbooking');
$sc = new mysqli('localhost','root','','scanner');

// lookup
$stmt = $bk->prepare(
  "SELECT * FROM bookings WHERE unique_code = ?"
);
$stmt->bind_param('s',$code);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows===0) {
  echo json_encode(['success'=>false,'error'=>'not found']); exit;
}
$row = $res->fetch_assoc();
$stmt->close();

// begin
$bk->begin_transaction();
$sc->begin_transaction();

try {
  // insert
  $cols = array_keys($row);
  $ph   = implode(',', array_fill(0,count($cols),'?'));
  $colL = implode(',', $cols);

  $types = '';
  $vals  = [];
  foreach ($cols as $c) {
    $types .= is_numeric($row[$c]) ? 'i' : 's';
    $vals[]  = $row[$c];
  }

  $ins = $sc->prepare("INSERT INTO booking ($colL) VALUES ($ph)");
  $ins->bind_param($types, ...$vals);
  $ins->execute();

  // delete
  $del = $bk->prepare("DELETE FROM bookings WHERE unique_code = ?");
  $del->bind_param('s',$code);
  $del->execute();

  $bk->commit();
  $sc->commit();

  echo json_encode([
    'success'=>true,
    'booking'=>$row
  ]);
} catch (Exception $e) {
  $bk->rollback();
  $sc->rollback();
  echo json_encode([
    'success'=>false,
    'error'=>$e->getMessage()
  ]);
}
