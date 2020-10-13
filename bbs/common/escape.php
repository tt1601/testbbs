<?php
function escape (string $str): string {
  return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
