DROP VIEW IF EXISTS public_opinions_v;
CREATE VIEW public_opinions_v AS
SELECT
  o.id,
  COALESCE(NULLIF(trim(o.name), ''), 'Anonim') AS author,
  o.message,
  o.created_at
FROM opinions o
ORDER BY o.created_at DESC;

DROP VIEW IF EXISTS opinions_daily_stats_v;
CREATE VIEW opinions_daily_stats_v AS
SELECT
  date_trunc('day', created_at)::date AS day,
  COUNT(*)::int AS opinions_count
FROM opinions
GROUP BY 1
ORDER BY 1 DESC;

DROP MATERIALIZED VIEW IF EXISTS opinions_last30_mv;
CREATE MATERIALIZED VIEW opinions_last30_mv AS
SELECT
  date_trunc('day', created_at)::date AS day,
  COUNT(*)::int AS opinions_count
FROM opinions
WHERE created_at >= (NOW() - INTERVAL '30 days')
GROUP BY 1
ORDER BY 1 DESC;

CREATE UNIQUE INDEX IF NOT EXISTS opinions_last30_mv_day_uniq
  ON opinions_last30_mv(day);
