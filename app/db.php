<?php
$host = '127.0.0.1';       // the server MySQL is running on
$db   = 'expense_demo';    // the database name
$user = 'expense_user';    // the MySQL username
$pass = 'expense_pass';    // the MySQL user’s password
$charset = 'utf8mb4';      // character set (handles emojis + full Unicode)


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    //PDO = PHP Data Objects, built-in PHP class for talking to databases
    //ATTR = attribute, settings on the PDO object that change how it behaves
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //ERRMODE_EXCEPTION => throw errors instead of failing silently
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //queries return associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false, //use real prepared statements, prevent sql injection
  ];
  
  $pdo = new PDO($dsn, $user, $pass, $options); //Data Source Name, username for DB auth, password for DB auth, options array
  //SQLite is a file-based DB and doesn’t require a username/password

  $pdo->exec("
 CREATE TABLE IF NOT EXISTS users ( 
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  email TEXT UNIQUE NOT NULL,
  password_hash TEXT NOT NULL,
  created_at TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS expenses (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER NOT NULL,
  amount_cents INTEGER NOT NULL,
  category TEXT NOT NULL,
  occurred_on TEXT NOT NULL,   -- stored as YYYY-MM-DD
  note TEXT,
  created_at TEXT NOT NULL DEFAULT (datetime('now')),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE INDEX IF NOT EXISTS idx_expenses_user_date 
  ON expenses(user_id, occurred_on);
");