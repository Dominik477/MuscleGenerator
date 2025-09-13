CREATE TABLE IF NOT EXISTS users (
  id           BIGSERIAL PRIMARY KEY,
  email        TEXT NOT NULL UNIQUE,
  password_hash TEXT NOT NULL,
  role         TEXT NOT NULL CHECK (role IN ('admin','user')),
  created_at   TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS users_role_idx ON users(role);
