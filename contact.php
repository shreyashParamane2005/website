<?php require 'db.php';
$n = trim($_POST['name'] ?? ''); $e = trim($_POST['email'] ?? ''); $m = trim($_POST['message'] ?? '');
if (!$n || !filter_var($e, FILTER_VALIDATE_EMAIL) || !$m) { header('Location: ../contact.html?error=Fill in all fields with a valid email'); exit; }
$st = $db->prepare('INSERT INTO messages(name,email,message) VALUES(?,?,?)'); $st->bind_param('sss', $n, $e, $m); $st->execute();
header('Location: ../contact.html?ok=Message sent. We will reply by email.');
