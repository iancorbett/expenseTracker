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

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Expense Tracker (Raw PHP + MySQL)</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; padding: 1.5rem; }
    table { border-collapse: collapse; width: 100%; margin-top: 1rem; }
    th, td { border: 1px solid #ddd; padding: 0.5rem; text-align: left; }
    th { background: #f5f5f5; }
    .amount { text-align: right; }
  </style>
</head>
<body>
  <h1>Expenses</h1>
  <p><a href="import.php">Import CSV</a></p>

  <?php if (!$rows): ?>
    <p>No expenses yet. Try importing a CSV!</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Category</th>
          <th>Amount</th>
          <th>Note</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= e($r['occurred_on']) ?></td>
            <td><?= e($r['category']) ?></td>
            <td class="amount">$<?= number_format($r['amount_cents'] / 100, 2) ?></td>
            <td><?= e($r['note']) ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>
</html>