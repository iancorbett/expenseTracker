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
  

  $header = fgetcsv($fh); //fgetcsv($fh) => PHP’s built-in function for reading a line from a CSV file
  if (!$header) throw new RuntimeException('Empty CSV'); //header is an array created, that holds comma separated values

  $map = array_flip(array_map('strtolower', $header)); //reverse keys and values, allows you to look up column ositions by name

  foreach (['date','category','amount'] as $need) {//these three fields are required
    if (!isset($map[$need])) throw new RuntimeException("Missing column: $need"); //if any of these three are not set, send error message
  }

  //createe reusable SQL query with placeholders instead of raw values
  $ins = $pdo->prepare("INSERT INTO expenses (user_id, amount_cents, category, occurred_on, note) 
  VALUES (?,?,?,?,?)");

$ok = 0; $fail = 0; $errors = [];



while (($row = fgetcsv($fh)) !== false) { //loop throgh each row in csv
    try {
      $date = trim($row[$map['date']] ?? ''); // ?? '' => if missing/null, default to empty string
      $cat  = trim($row[$map['category']] ?? ''); // ?? '' => if missing/null, default to empty string
      $amt  = trim($row[$map['amount']] ?? '');// ?? '' => if missing/null, default to empty string
      $note = isset($map['note']) ? trim($row[$map['note']] ?? '') : ''; //isset() => core php function, returns true if variable exists and is not null

      if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) throw new RuntimeException('Bad date'); //use regex to determine if date is valid
      if ($cat === '') throw new RuntimeException('Bad category'); //print error message if category is empty
      $cents = parse_amount_to_cents($amt);

      $ins->execute([$uid, $cents, $cat, $date, $note]);//these 5 values will replace the "?" placeholders
      $ok++; //increment $ok for each success
    } catch (Throwable $e) {
      $fail++; $errors[] = $e->getMessage(); //increment $fail for each failure and save errors in an array
    }
  }
  fclose($fh); //close file

  return ['ok'=>$ok, 'fail'=>$fail, 'errors'=>$errors];
};

$msg = '';//initialize message to empty string

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check to see if request made was POST
csrf_require(); //Makes sure the hidden CSRF token in the form matches the one in the session
try {
    if (!empty($_FILES['csv']['tmp_name'])) { //check if csv file was acutally uploaded
        $res = import_csv($pdo, $uid, $_FILES['csv']['tmp_name']); //call import function usimg the database connection, user id, and the temporary file path 
        $msg = "Uploaded CSV imported. OK={$res['ok']}, FAIL={$res['fail']}";
    } else {
        $msg = "Please choose a CSV file.";
      }
} catch (Throwable $e) {
    $msg = "Import error: " . $e->getMessage();
  }
}
