<?php require 'db.php';
$e = trim($_POST['email'] ?? ''); $p = $_POST['password'] ?? '';
$st = $db->prepare('SELECT id,name,password FROM users WHERE email=?'); $st->bind_param('s', $e); $st->execute();
$u = $st->get_result()->fetch_assoc();
if ($u && password_verify($p, $u['password'])) {
  session_regenerate_id(true); $_SESSION['uid'] = $u['id']; $_SESSION['name'] = $u['name'];
  header('Location: ../movies.html');
} else header('Location: ../login.html?error=Wrong email or password');
