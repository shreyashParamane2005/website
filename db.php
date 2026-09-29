<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'ticket_booking'); // XAMPP defaults
if ($db->connect_error) { http_response_code(500); exit('Database connection failed'); }
$db->set_charset('utf8mb4');
