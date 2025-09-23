<?php
function csrf_token(){ //Cross-Site Request Forgery
  if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));// if no sesssion, create one, generate token and return it
  return $_SESSION['csrf'];
}