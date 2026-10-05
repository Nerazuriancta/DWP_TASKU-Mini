<?php

require_once __DIR__ . '/../includes/session.php';

session_unset();
session_destroy();

header('Location: /Jobsheet-11/auth/login.php');
exit;