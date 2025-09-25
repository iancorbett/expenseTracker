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