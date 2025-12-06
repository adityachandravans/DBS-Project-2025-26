-- QUICK FIX: Add missing columns to existing users table
-- Run this if you already have a users table without OTP columns

USE inventory_db;

-- Check if columns exist and add them if missing
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS is_verified TINYINT(1) DEFAULT 0,
ADD COLUMN IF NOT EXISTS otp VARCHAR(6) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS otp_expiry DATETIME DEFAULT NULL;

-- Add indexes for better performance
ALTER TABLE users 
ADD INDEX IF NOT EXISTS idx_email (email),
ADD INDEX IF NOT EXISTS idx_otp (otp);

-- Verify the structure
DESCRIBE users;
