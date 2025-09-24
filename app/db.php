<?php
$host = '127.0.0.1';       // the server MySQL is running on
$port = '3306';             // select port 3306
$db   = 'expense_demo';    // the database name
$user = 'expense_user';    // the MySQL username
$pass    = '';  // start as empty string
$charset = 'utf8mb4';      // character set (handles emojis + full Unicode)


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    //PDO = PHP Data Objects, built-in PHP class for talking to databases
    //ATTR = attribute, settings on the PDO object that change how it behaves
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //ERRMODE_EXCEPTION => throw errors instead of failing silently
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //queries return associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false, //use real prepared statements, prevent sql injection
  ];
  
  $dsnServer = "mysql:host=$host;port=$port;charset=$charset";
  try {
  $pdo = new PDO($dsn, $user, $pass, $options); //Data Source Name, username for DB auth, password for DB auth, options array
  } catch (PDOException $e) {
    die("DB connect (server) failed: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
  }

  $pdo->exec("
 CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS expenses (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  amount_cents INT NOT NULL,
  category VARCHAR(100) NOT NULL,
  occurred_on DATE NOT NULL,
  note VARCHAR(255),
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_expenses_user FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_expenses_user_date ON expenses(user_id, occurred_on);
");