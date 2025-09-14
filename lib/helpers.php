<?php
declare(strict_types=1);

function csrf_token(): string {
  if (empty($_SESSION['__csrf'])) {
    $_SESSION['__csrf'] = bin2hex(random_bytes(16));
  }
  return $_SESSION['__csrf'];
}
function csrf_field(): string {
  return '<input type="hidden" name="__csrf" value="'.htmlspecialchars(csrf_token(), ENT_QUOTES).'">';
}
function csrf_verify(): bool {
  return isset($_POST['__csrf']) && hash_equals($_SESSION['__csrf'] ?? '', (string)$_POST['__csrf']);
}

function honeypot_ok(string $field = 'website'): bool {
  return empty($_POST[$field] ?? '');
}

function str_trimmed(?string $v): string { return trim((string)$v); }
function not_empty(string $v): bool { return $v !== ''; }
function email_valid(string $v): bool { return filter_var($v, FILTER_VALIDATE_EMAIL) !== false; }

function jsonl_append(string $filepath, array $row): bool {
  $dir = dirname($filepath);
  if (!is_dir($dir)) @mkdir($dir, 0777, true);
  $fh = @fopen($filepath, 'ab');
  if (!$fh) return false;
  $row['created_at'] = date('c');
  $ok = fwrite($fh, json_encode($row, JSON_UNESCAPED_UNICODE) . PHP_EOL) !== false;
  fclose($fh);
  return $ok;
}
function jsonl_read_all(string $filepath): array {
  if (!is_file($filepath)) return [];
  $out = [];
  foreach (file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $dec = json_decode($line, true);
    if (is_array($dec)) $out[] = $dec;
  }
  return $out;
}

function redirect(string $url): void {
  if (!headers_sent()) {
    header("Location: $url", true, 302);
    exit;
  }
  echo '<!doctype html><meta http-equiv="refresh" content="0;url=' . htmlspecialchars($url, ENT_QUOTES) . '">';
  echo '<script>location.replace(' . json_encode($url) . ');</script>';
  exit;
}


function flash_add(string $type, string $message): void {
  $_SESSION['__flash'][] = ['type' => $type, 'message' => $message];
}
function flash_get_all(): array {
  $msgs = $_SESSION['__flash'] ?? [];
  unset($_SESSION['__flash']);
  return $msgs;
}

