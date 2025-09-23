
<?php
$dsn = 'sqlite:' . __DIR__ . '/../data/app.db'; //Data Source Name

$options = [
    //PDO = PHP Data Objects, built-in PHP class for talking to databases
    //ATTR = attribute, settings on the PDO object that change how it behaves
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //ERRMODE_EXCEPTION => throw errors instead of failing silently
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //queries return associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false, //use real prepared statements, prevent sql injection
  ];
  
  $pdo = new PDO($dsn, null, null, $options); //Data Source Name, username for DB auth, password for DB auth, options array
  //SQLite is a file-based DB and doesn’t require a username/password

  