<?php

require __DIR__ . '/../app/bootstrap.php'; //Pulls in bootstrap.php (which itself loads db.php, csrf.php

$uid = $_SESSION['uid'] ?? 1; //hardcoded user id 1

$pdo->prepare("INSERT IGNORE INTO users (id,email,password_hash) VALUES (1,'demo@example.com','demo')") //Makes sure a demo user is in the database
    ->execute();
$_SESSION['uid'] = $uid;

//fetch expenses
$stmt = $pdo->prepare("
  SELECT e.id, e.occurred_on, e.category, e.amount_cents, e.note, u.email
  FROM expenses e
  JOIN users u ON e.user_id = u.id
  WHERE e.user_id = ?
  ORDER BY e.occurred_on DESC, e.id DESC
");

$stmt->execute([$uid]); //execute statement with user id
$rows = $stmt->fetchAll(); // get all rows as arrays
?>