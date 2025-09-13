ALTER TABLE opinions         ADD COLUMN IF NOT EXISTS updated_at TIMESTAMPTZ;
ALTER TABLE contact_messages ADD COLUMN IF NOT EXISTS updated_at TIMESTAMPTZ;

CREATE OR REPLACE FUNCTION set_updated_at()
RETURNS TRIGGER AS $$
BEGIN
  NEW.updated_at := NOW();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_opinions_updated_at ON opinions;
CREATE TRIGGER trg_opinions_updated_at
BEFORE UPDATE ON opinions
FOR EACH ROW EXECUTE FUNCTION set_updated_at();

DROP TRIGGER IF EXISTS trg_contact_updated_at ON contact_messages;
CREATE TRIGGER trg_contact_updated_at
BEFORE UPDATE ON contact_messages
FOR EACH ROW EXECUTE FUNCTION set_updated_at();

CREATE OR REPLACE FUNCTION normalize_user_email()
RETURNS TRIGGER AS $$
BEGIN
  NEW.email := lower(trim(NEW.email));
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_users_normalize_email ON users;
CREATE TRIGGER trg_users_normalize_email
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW EXECUTE FUNCTION normalize_user_email();

CREATE UNIQUE INDEX IF NOT EXISTS users_email_lower_uniq
  ON users (lower(email));


CREATE OR REPLACE FUNCTION prevent_opinion_spam()
RETURNS TRIGGER AS $$
DECLARE
  recent_count INT;
BEGIN
  SELECT COUNT(*) INTO recent_count
  FROM opinions
  WHERE ip = NEW.ip
    AND created_at >= (NOW() - INTERVAL '30 sekund');

  IF recent_count > 0 THEN
    RAISE EXCEPTION 'Za dużo opinii z tego adresu IP. Proszę chwilę odczekać.';
  END IF;

  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_opinions_antispam ON opinions;
CREATE TRIGGER trg_opinions_antispam
BEFORE INSERT ON opinions
FOR EACH ROW EXECUTE FUNCTION prevent_opinion_spam();
