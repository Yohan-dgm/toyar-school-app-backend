/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_backend_v1
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 11/08/2025 17:30:00
*/

-- ----------------------------
-- Sequence structure for announcements_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."announcements_id_seq";

CREATE SEQUENCE "public"."announcements_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for announcements
-- ----------------------------
DROP TABLE IF EXISTS "public"."announcements";

CREATE TABLE "public"."announcements" (
    "id" int8 NOT NULL DEFAULT nextval('announcements_id_seq'::regclass),
    "title" varchar(500) COLLATE "pg_catalog"."default" NOT NULL,
    "content" text COLLATE "pg_catalog"."default" NOT NULL,
    "excerpt" text COLLATE "pg_catalog"."default",
    "category_id" int8 NOT NULL,
    "priority_level" int4 NOT NULL DEFAULT 1,
    "status" varchar(20) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'draft',
    "target_type" varchar(50) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'broadcast',
    "target_data" jsonb,
    "image_url" varchar(500) COLLATE "pg_catalog"."default",
    "attachment_urls" jsonb,
    "is_featured" bool DEFAULT false,
    "is_pinned" bool DEFAULT false,
    "scheduled_at" timestamp(0),
    "published_at" timestamp(0),
    "expires_at" timestamp(0),
    "view_count" int4 DEFAULT 0,
    "like_count" int4 DEFAULT 0,
    "school_id" int8,
    "notification_sent" bool DEFAULT false,
    "notification_id" int8,
    "tags" varchar(500) COLLATE "pg_catalog"."default",
    "meta_data" jsonb,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "deleted_at" timestamp(0)
);

-- ----------------------------
-- Records of announcements
-- ----------------------------
INSERT INTO "public"."announcements" VALUES
    (1, 'Welcome to Academic Year 2025-2026', 'We are delighted to welcome all students, parents, and staff to the new academic year 2025-2026. This year promises to bring exciting opportunities, innovative learning experiences, and continued growth for our school community.', 'Welcome message for the new academic year 2025-2026 with exciting opportunities ahead.', 1, 2, 'published', 'broadcast', '{}', NULL, NULL, 't', 't', NULL, '2025-08-11 08:00:00', '2025-12-31 23:59:59', 125, 45, 1, 't', 15, 'welcome,academic-year,2025', '{"author_note": "Official welcome message", "publish_immediately": true}', 1, NULL, '2025-08-10 16:00:00', '2025-08-11 08:00:00', NULL),
    (2, 'Mid-Term Examination Schedule Released', 'The mid-term examination schedule for all grades has been finalized and is now available. Students and parents are requested to review the schedule carefully and prepare accordingly. Examination halls and timing details are included.', 'Mid-term exam schedule now available for all grades with detailed timing and hall information.', 2, 3, 'published', 'broadcast', '{}', '/storage/announcements/exam-schedule-2025.pdf', '["\/storage\/announcements\/exam-schedule-2025.pdf", "\/storage\/announcements\/exam-guidelines.pdf"]', 't', 'f', NULL, '2025-08-11 10:30:00', '2025-09-30 23:59:59', 89, 23, 1, 't', 16, 'exams,mid-term,schedule', '{"priority_reason": "Important academic milestone"}', 1, NULL, '2025-08-11 09:00:00', '2025-08-11 10:30:00', NULL),
    (3, 'Annual Sports Day Registration Open', 'Registration for the Annual Sports Day 2025 is now open for all students. Various events including track and field, team sports, and individual competitions are available. Registration deadline is August 25th, 2025.', 'Annual Sports Day 2025 registration is open with various events and competitions available.', 6, 2, 'published', 'role', '{"roles": ["student", "parent"]}', '/storage/announcements/sports-day-banner.jpg', '["\/storage\/announcements\/sports-registration-form.pdf"]', 't', 'f', NULL, '2025-08-11 14:00:00', '2025-08-25 23:59:59', 67, 34, 1, 't', 17, 'sports,registration,annual-event', '{"event_date": "2025-09-15", "registration_fee": "₹500"}', 1, NULL, '2025-08-11 13:00:00', '2025-08-11 14:00:00', NULL),
    (4, 'Emergency Weather Alert - School Closure', 'Due to severe weather warnings issued by the meteorological department, the school will remain closed on August 12th, 2025. All classes, activities, and events scheduled for this date are postponed. Regular operations will resume on August 13th, 2025.', 'School closure on August 12th due to severe weather warnings. Operations resume August 13th.', 4, 3, 'published', 'broadcast', '{}', NULL, NULL, 'f', 't', NULL, '2025-08-11 18:00:00', '2025-08-13 23:59:59', 234, 67, 1, 't', 18, 'emergency,weather,closure', '{"alert_level": "high", "safety_priority": true}', 1, NULL, '2025-08-11 17:30:00', '2025-08-11 18:00:00', NULL),
    (5, 'Parent-Teacher Conference Schedule', 'The quarterly parent-teacher conferences have been scheduled for August 20-22, 2025. Parents can book their preferred time slots through the school portal or by calling the administration office. Individual meeting schedules will be sent via SMS.', 'Quarterly parent-teacher conferences scheduled for August 20-22, 2025. Booking now available.', 3, 2, 'scheduled', 'role', '{"roles": ["parent", "teacher"]}', NULL, '["\/storage\/announcements\/conference-booking-guide.pdf"]', 'f', 'f', '2025-08-15 06:00:00', NULL, '2025-08-25 23:59:59', 0, 0, 1, 'f', NULL, 'parent-teacher,conference,meeting', '{"booking_system": "online", "duration": "15_minutes_per_meeting"}', 1, NULL, '2025-08-11 15:00:00', '2025-08-11 15:00:00', NULL);

-- ----------------------------
-- Primary Key structure for table announcements
-- ----------------------------
ALTER TABLE "public"."announcements" 
ADD CONSTRAINT "announcements_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Check constraints
-- ----------------------------
ALTER TABLE "public"."announcements" 
ADD CONSTRAINT "announcements_priority_level_check" 
CHECK (priority_level IN (1, 2, 3));

ALTER TABLE "public"."announcements" 
ADD CONSTRAINT "announcements_status_check" 
CHECK (status IN ('draft', 'scheduled', 'published', 'archived'));

ALTER TABLE "public"."announcements" 
ADD CONSTRAINT "announcements_target_type_check" 
CHECK (target_type IN ('broadcast', 'role', 'class', 'grade', 'user', 'school'));

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."announcements_id_seq" 
OWNED BY "public"."announcements"."id";

SELECT setval('"public"."announcements_id_seq"', 5, true);

-- ----------------------------
-- Indexes for table announcements
-- ----------------------------
CREATE INDEX "idx_announcements_category_id" ON "public"."announcements" USING btree ("category_id");
CREATE INDEX "idx_announcements_priority_level" ON "public"."announcements" USING btree ("priority_level");
CREATE INDEX "idx_announcements_status" ON "public"."announcements" USING btree ("status");
CREATE INDEX "idx_announcements_target_type" ON "public"."announcements" USING btree ("target_type");
CREATE INDEX "idx_announcements_school_id" ON "public"."announcements" USING btree ("school_id");
CREATE INDEX "idx_announcements_created_by" ON "public"."announcements" USING btree ("created_by");
CREATE INDEX "idx_announcements_created_at" ON "public"."announcements" USING btree ("created_at" DESC);
CREATE INDEX "idx_announcements_published_at" ON "public"."announcements" USING btree ("published_at" DESC);
CREATE INDEX "idx_announcements_scheduled_at" ON "public"."announcements" USING btree ("scheduled_at") WHERE scheduled_at IS NOT NULL;
CREATE INDEX "idx_announcements_expires_at" ON "public"."announcements" USING btree ("expires_at") WHERE expires_at IS NOT NULL;
CREATE INDEX "idx_announcements_is_featured" ON "public"."announcements" USING btree ("is_featured") WHERE is_featured = true;
CREATE INDEX "idx_announcements_is_pinned" ON "public"."announcements" USING btree ("is_pinned") WHERE is_pinned = true;
CREATE INDEX "idx_announcements_deleted_at" ON "public"."announcements" USING btree ("deleted_at") WHERE deleted_at IS NOT NULL;
CREATE INDEX "idx_announcements_notification_sent" ON "public"."announcements" USING btree ("notification_sent");

-- ----------------------------
-- Full-text search index for content
-- ----------------------------
CREATE INDEX "idx_announcements_search" ON "public"."announcements" 
USING gin(to_tsvector('english', title || ' ' || content || ' ' || COALESCE(tags, '')));

-- ----------------------------
-- Foreign key constraints (commented out - add when related tables exist)
-- ----------------------------
-- ALTER TABLE "public"."announcements" 
-- ADD CONSTRAINT "fk_announcements_category" 
-- FOREIGN KEY ("category_id") REFERENCES "public"."announcement_categories" ("id");

-- ALTER TABLE "public"."announcements" 
-- ADD CONSTRAINT "fk_announcements_notification" 
-- FOREIGN KEY ("notification_id") REFERENCES "public"."notifications" ("id");

-- ALTER TABLE "public"."announcements" 
-- ADD CONSTRAINT "fk_announcements_created_by" 
-- FOREIGN KEY ("created_by") REFERENCES "public"."users" ("id");

-- ALTER TABLE "public"."announcements" 
-- ADD CONSTRAINT "fk_announcements_updated_by" 
-- FOREIGN KEY ("updated_by") REFERENCES "public"."users" ("id");