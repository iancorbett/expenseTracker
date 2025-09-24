<?php

require __DIR__ . '/../app/bootstrap.php';

$pdo->prepare("INSERT IGNORE INTO users (id, email, password_hash) VALUES (1,'demo@example.com','demo')")->execute();
$_SESSION['uid'] = 1; //Stores the user id in the session
$uid = 1;

function parse_amount_to_cents(string $amount): int { //takes in a string, returns an int, 
    if (!preg_match('/^\d+(\.\d{1,2})?$/', trim($amount))) throw new RuntimeException('Invalid amount'); //use regex validation to make sure amount entry is what we are looking for
    return (int)round((float)$amount * 100); // * 100 => converts to cents, then round value to get correct value, then convert to int
  }

  function import_csv(PDO $pdo, int $uid, string $path): array { //PDO DB connection, the user ID to tie each expense to, the file path of the CSV file to import
    if (!is_file($path)) throw new RuntimeException("CSV not found: $path"); //return error if no file found at that path
    $fh = fopen($path, 'r'); //Opens the file for reading
    if (!$fh) throw new RuntimeException('Cannot open CSV'); //catch error if it cant be opened
  };  