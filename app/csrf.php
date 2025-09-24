<?php
function csrf_token(){ //Cross-Site Request Forgery
  if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));// if no sesssion, create one, generate token and return it
  return $_SESSION['csrf'];
}

function csrf_field(){ return '<input type="hidden" name="csrf" value="'.htmlspecialchars(csrf_token(), ENT_QUOTES).'">'; } //returns html element that holds csrf token so its sent with html form

function csrf_require(){
    $ok = isset($_POST['csrf']) && hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf']);
    if (!$ok) { http_response_code(419); exit('CSRF failed'); }
  }