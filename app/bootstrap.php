<?php
session_start(); // track logged-in users across requests

date_default_timezone_set('America/Los_Angeles'); //just learned san jose maps to costa rica not san jose, ca. so using LA instead

require __DIR__ . '/db.php'; //db connection


function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } //prevents cross server scripting, converts special characters to html text
