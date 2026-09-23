-- Okie Heating & Cooling — MySQL schema
-- Import via hPanel -> Databases -> phpMyAdmin, or: mysql -u USER -p DBNAME < sql/schema.sql

CREATE TABLE IF NOT EXISTS service_requests (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  phone VARCHAR(40) NOT NULL,
  email VARCHAR(160) NOT NULL DEFAULT '',
  address VARCHAR(200) NOT NULL DEFAULT '',
  city VARCHAR(100) NOT NULL DEFAULT '',
  service_type VARCHAR(50) NOT NULL,
  issue_description TEXT NULL,
  preferred_date VARCHAR(20) NOT NULL DEFAULT '',
  preferred_time VARCHAR(20) NOT NULL DEFAULT '',
  urgency ENUM('routine','soon','urgent','emergency') NOT NULL DEFAULT 'routine',
  customer_type ENUM('new','existing') NOT NULL DEFAULT 'new',
  form_source VARCHAR(60) NOT NULL DEFAULT 'website',
  utm_source VARCHAR(100) NOT NULL DEFAULT '',
  utm_medium VARCHAR(100) NOT NULL DEFAULT '',
  utm_campaign VARCHAR(100) NOT NULL DEFAULT '',
  consent TINYINT(1) NOT NULL DEFAULT 0,
  consent_at DATETIME NULL,
  consent_text VARCHAR(500) NULL,
  consent_ip VARCHAR(45) NULL,
  status ENUM('new','contacted','scheduled','completed','cancelled') NOT NULL DEFAULT 'new',
  notes TEXT NULL,
  email_sent TINYINT(1) NOT NULL DEFAULT 0,
  ip VARCHAR(45) NOT NULL DEFAULT '',
  user_agent VARCHAR(255) NOT NULL DEFAULT '',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_created (created_at),
  INDEX idx_status (status),
  INDEX idx_service (service_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Re-running this file against an already-deployed table (CREATE TABLE above
-- is a no-op then) still picks up columns added after the table first existed.
-- Needs MySQL 8.0.29+ / MariaDB 10.0+ for "ADD COLUMN IF NOT EXISTS".
ALTER TABLE service_requests
  ADD COLUMN IF NOT EXISTS consent_at DATETIME NULL AFTER consent,
  ADD COLUMN IF NOT EXISTS consent_text VARCHAR(500) NULL AFTER consent_at,
  ADD COLUMN IF NOT EXISTS consent_ip VARCHAR(45) NULL AFTER consent_text;

CREATE TABLE IF NOT EXISTS site_events (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  event_name VARCHAR(60) NOT NULL,
  path VARCHAR(255) NOT NULL DEFAULT '',
  referrer VARCHAR(500) NOT NULL DEFAULT '',
  visitor_id VARCHAR(64) NOT NULL DEFAULT '',
  session_id VARCHAR(64) NOT NULL DEFAULT '',
  form_source VARCHAR(60) NOT NULL DEFAULT '',
  service_type VARCHAR(50) NOT NULL DEFAULT '',
  utm_source VARCHAR(100) NOT NULL DEFAULT '',
  utm_medium VARCHAR(100) NOT NULL DEFAULT '',
  utm_campaign VARCHAR(100) NOT NULL DEFAULT '',
  properties JSON NULL,
  ip VARCHAR(45) NOT NULL DEFAULT '',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_event_created (event_name, created_at),
  INDEX idx_visitor (visitor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
