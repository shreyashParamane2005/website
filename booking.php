<?php require 'db.php'; header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($_SESSION['uid'])) { http_response_code(401); exit(json_encode(['error' => 'login'])); }
  $d = json_decode(file_get_contents('php://input'), true);
  $show = (int)($d['show_id'] ?? 0); $ok = 0;
  $st = $db->prepare('INSERT INTO bookings(user_id,show_id,seat) VALUES(?,?,?)');
  foreach (($d['seats'] ?? []) as $s) {
    $s = substr((string)$s, 0, 5); $uid = $_SESSION['uid'];
    $st->bind_param('iis', $uid, $show, $s);
    try { if ($st->execute()) $ok++; } catch (Throwable $x) {} // seat already taken
  }
  exit(json_encode(['booked' => $ok]));
}
$a = $_GET['action'] ?? '';
if ($a === 'me') exit(json_encode(['name' => $_SESSION['name'] ?? null]));
if ($a === 'movies') $r = $db->query('SELECT * FROM movies');
elseif ($a === 'shows') { $id = (int)$_GET['movie_id'];
  $r = $db->query("SELECT s.id,s.show_time,m.price,m.title FROM shows s JOIN movies m ON m.id=s.movie_id WHERE s.movie_id=$id AND s.show_time>NOW() ORDER BY s.show_time"); }
elseif ($a === 'seats') { $id = (int)$_GET['show_id']; $r = $db->query("SELECT seat FROM bookings WHERE show_id=$id"); }
else exit('[]');
echo json_encode($r->fetch_all(MYSQLI_ASSOC));
