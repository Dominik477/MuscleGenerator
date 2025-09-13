<?php
declare(strict_types=1);

function auth_login(int $userId, string $role, string $email): void {
  $_SESSION['__uid']  = $userId;
  $_SESSION['__role'] = $role;
  $_SESSION['__email']= $email;
}

function auth_logout(): void {
  unset($_SESSION['__uid'], $_SESSION['__role'], $_SESSION['__email']);
}

function auth_user_id(): ?int {
  return isset($_SESSION['__uid']) ? (int)$_SESSION['__uid'] : null;
}

function auth_role(): ?string {
  return $_SESSION['__role'] ?? null;
}

function auth_email(): ?string {
  return $_SESSION['__email'] ?? null;
}

function auth_is(string $role): bool {
  return (auth_role() === $role);
}

function auth_logged(): bool {
  return auth_user_id() !== null;
}

function require_role(string $role): void {
  if (!auth_logged() || !auth_is($role)) {
    flash_add('error', 'Brak uprawnień.');
    redirect('/?page=home');
  }
}
