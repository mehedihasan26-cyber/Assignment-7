<?php
require_once __DIR__ . '/classes/SessionManager.php';
$s = new SessionManager();
$s->logout();
header('Location: login.php');
exit;
