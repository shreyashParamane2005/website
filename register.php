<?php require 'db.php';
$n = trim($_POST['name'] ?? ''); $e = trim($_POST['email'] ?? ''); $p = $_POST['password'] ?? '';
if (!$n || !filter_var($e, FILTER_VALIDATE_EMAIL) || strlen($p) < 6) { header('Location: ../register.html?error=Enter a name, a valid email and a password of 6+ characters'); exit; }
$h = password_hash($p, PASSWORD_DEFAULT);
$st = $db->prepare('INSERT INTO users(name,email,password) VALUES(?,?,?)'); $st->bind_param('sss', $n, $e, $h);
try { $st->execute(); header('Location: ../login.html?ok=Account created. Log in to book.'); }
catch (Throwable $x) { header('Location: ../register.html?error=That email is already registered'); }
