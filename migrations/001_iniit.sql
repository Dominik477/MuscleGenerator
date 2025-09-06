CREATE TABLE IF NOT EXISTS opinions (
  id          BIGSERIAL PRIMARY KEY,
  name        TEXT NOT NULL,
  message     TEXT NOT NULL,
  ip          TEXT,
  ua          TEXT,
  created_at  TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS contact_messages (
  id          BIGSERIAL PRIMARY KEY,
  name        TEXT NOT NULL,
  email       TEXT NOT NULL,
  message     TEXT NOT NULL,
  ip          TEXT,
  ua          TEXT,
  created_at  TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS opinions_created_at_idx ON opinions (created_at DESC);
CREATE INDEX IF NOT EXISTS contact_messages_created_at_idx ON contact_messages (created_at DESC);
