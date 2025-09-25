# Expense Tracker (Raw PHP + PDO + MySQL)

This is a simple **raw PHP** demo project built without frameworks.  
It connects to a MySQL database with PDO, imports records from a CSV file,  
and displays them in an HTML table.

This project was created to demonstrate **custom PHP development** skills  
outside of Laravel or other frameworks.

---

## Features
- Connects to MySQL using **PDO**
- Creates database & tables automatically on first run
- **Imports expenses from a CSV file** (upload or bundled `data.csv`)
- Stores amounts safely as integer cents to avoid floating point issues
- **Prepared statements** used everywhere to prevent SQL injection
- **CSRF token + XSS escaping** for basic security
- Displays results in a clean HTML table

---

##  Sample CSV Format

date,category,amount,note
2025-09-01,Food,12.50,Lunch burrito
2025-09-03,Travel,45.00,Bus ticket
2025-09-05,Books,20.00,PHP textbook

---

## Setup

1. Clone the repo:

git clone https://github.com/YOUR_USERNAME/expense-tracker-php.git
cd expense-tracker-php


2. Run PHP’s built-in server:

php -S localhost:3000 -t public


3. Visit:

http://localhost:3000/import.php
 → upload/import CSV

http://localhost:3000/index.php
 → view table

 ---