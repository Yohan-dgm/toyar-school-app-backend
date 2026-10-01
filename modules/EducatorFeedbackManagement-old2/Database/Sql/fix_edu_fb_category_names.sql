-- ============================================================================
-- SQL Script to Fix Educator Feedback Category Names
-- ============================================================================
-- Purpose: Update three category names to match the required specification
-- Date: 2025-10-13
--
-- IMPORTANT: Run this script on your PostgreSQL database to update the
-- existing category names in the edu_fb_category table.
-- ============================================================================

-- Fix Category ID 3: "Music Intelligence" → "Musical Intelligence"
UPDATE "public"."edu_fb_category"
SET "name" = 'Musical Intelligence', "updated_at" = CURRENT_TIMESTAMP
WHERE "id" = 3;

-- Fix Category ID 6: "Mathematical / Logical Intelligence" → "Mathematical/Logical Intelligence"
UPDATE "public"."edu_fb_category"
SET "name" = 'Mathematical/Logical Intelligence', "updated_at" = CURRENT_TIMESTAMP
WHERE "id" = 6;

-- Fix Category ID 10: "Contribution to School Community" → "Contribution to the School Community"
UPDATE "public"."edu_fb_category"
SET "name" = 'Contribution to the School Community', "updated_at" = CURRENT_TIMESTAMP
WHERE "id" = 10;

-- Verify the changes
SELECT "id", "name", "is_active", "updated_at"
FROM "public"."edu_fb_category"
WHERE "id" IN (3, 6, 10)
ORDER BY "id";

-- ============================================================================
-- Expected Result After Running This Script:
-- ============================================================================
-- ID | Name                                      | is_active | updated_at
-- ---|-------------------------------------------|-----------|-------------------
--  3 | Musical Intelligence                      | t         | (current timestamp)
--  6 | Mathematical/Logical Intelligence         | t         | (current timestamp)
-- 10 | Contribution to the School Community      | t         | (current timestamp)
-- ============================================================================
