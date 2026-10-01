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

 Date: 11/08/2025 16:50:00
*/

-- ----------------------------
-- Sequence structure for notifications_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."notifications_id_seq";

CREATE SEQUENCE "public"."notifications_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS "public"."notifications";

CREATE TABLE "public"."notifications" (
    "id" int8 NOT NULL DEFAULT nextval('notifications_id_seq'::regclass),
    "notification_type_id" int8 NOT NULL,
    "title" varchar(500) COLLATE "pg_catalog"."default" NOT NULL,
    "message" text COLLATE "pg_catalog"."default" NOT NULL,
    "priority" varchar(20) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'normal',
    "target_type" varchar(50) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'broadcast',
    "target_data" jsonb,
    "action_url" varchar(500) COLLATE "pg_catalog"."default",
    "action_text" varchar(100) COLLATE "pg_catalog"."default",
    "image_url" varchar(500) COLLATE "pg_catalog"."default",
    "is_scheduled" bool DEFAULT false,
    "scheduled_at" timestamp(0),
    "sent_at" timestamp(0),
    "expires_at" timestamp(0),
    "school_id" int8,
    "total_recipients" int4 DEFAULT 0,
    "total_sent" int4 DEFAULT 0,
    "total_delivered" int4 DEFAULT 0,
    "total_read" int4 DEFAULT 0,
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "deleted_at" timestamp(0)
);

-- ----------------------------
-- Records of notifications
-- ----------------------------
INSERT INTO "public"."notifications" VALUES
    (1, 2, 'Welcome to New Academic Year 2025', 'We are excited to welcome all students and parents to the new academic year 2025. This year brings new opportunities and exciting changes to our curriculum.', 'normal', 'broadcast', '{}', '/academic/year-2025', 'View Details', NULL, 'f', NULL, '2025-08-11 09:00:00', NULL, 1, 150, 150, 148, 45, 't', 1, NULL, '2025-08-11 09:00:00', '2025-08-11 09:00:00', NULL),
    (2, 4, 'Parent-Teacher Meeting Scheduled', 'Parent-Teacher meetings have been scheduled for August 25th, 2025. Please check your individual schedules for specific timings.', 'high', 'role', '{"roles": ["parent", "teacher"]}', '/events/parent-teacher-meeting', 'Book Slot', NULL, 'f', NULL, '2025-08-11 10:30:00', NULL, 1, 85, 85, 83, 12, 't', 1, NULL, '2025-08-11 10:30:00', '2025-08-11 10:30:00', NULL),
    (3, 5, 'Emergency School Closure Notice', 'Due to severe weather conditions, the school will be closed tomorrow (August 12th, 2025). All classes are cancelled and will resume on August 13th.', 'urgent', 'broadcast', '{}', NULL, NULL, NULL, 'f', NULL, '2025-08-11 15:45:00', '2025-08-13 23:59:59', 1, 200, 200, 195, 180, 't', 1, NULL, '2025-08-11 15:45:00', '2025-08-11 15:45:00', NULL),
    (4, 3, 'Grade 10 Mathematics Assignment Due', 'Reminder: Your Mathematics assignment on Trigonometry is due on August 15th, 2025. Please submit your work on time.', 'normal', 'class', '{"grade_level_class_ids": [10]}', '/assignments/math-trigonometry', 'Submit Assignment', NULL, 't', '2025-08-14 08:00:00', NULL, '2025-08-15 23:59:59', 1, 25, 0, 0, 0, 't', 1, NULL, '2025-08-11 11:00:00', '2025-08-11 11:00:00', NULL),
    (5, 6, 'Attendance Alert - Multiple Absences', 'Your child has been absent for 3 consecutive days. Please contact the school office to discuss this matter.', 'high', 'user', '{"user_id": 45}', '/attendance/student/view', 'View Attendance', NULL, 'f', NULL, '2025-08-11 14:20:00', NULL, 1, 1, 1, 1, 0, 't', 1, NULL, '2025-08-11 14:20:00', '2025-08-11 14:20:00', NULL);

-- ----------------------------
-- Primary Key structure for table notifications
-- ----------------------------
ALTER TABLE "public"."notifications" 
ADD CONSTRAINT "notifications_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Check constraints
-- ----------------------------
ALTER TABLE "public"."notifications" 
ADD CONSTRAINT "notifications_priority_check" 
CHECK (priority IN ('normal', 'high', 'urgent'));

ALTER TABLE "public"."notifications" 
ADD CONSTRAINT "notifications_target_type_check" 
CHECK (target_type IN ('broadcast', 'user', 'role', 'class', 'grade', 'school'));

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."notifications_id_seq" 
OWNED BY "public"."notifications"."id";

SELECT setval('"public"."notifications_id_seq"', 5, true);

-- ----------------------------
-- Indexes for table notifications
-- ----------------------------
CREATE INDEX "idx_notifications_type_id" ON "public"."notifications" USING btree ("notification_type_id");
CREATE INDEX "idx_notifications_priority" ON "public"."notifications" USING btree ("priority");
CREATE INDEX "idx_notifications_target_type" ON "public"."notifications" USING btree ("target_type");
CREATE INDEX "idx_notifications_school_id" ON "public"."notifications" USING btree ("school_id");
CREATE INDEX "idx_notifications_created_by" ON "public"."notifications" USING btree ("created_by");
CREATE INDEX "idx_notifications_created_at" ON "public"."notifications" USING btree ("created_at" DESC);
CREATE INDEX "idx_notifications_scheduled_at" ON "public"."notifications" USING btree ("scheduled_at") WHERE is_scheduled = true;
CREATE INDEX "idx_notifications_expires_at" ON "public"."notifications" USING btree ("expires_at") WHERE expires_at IS NOT NULL;
CREATE INDEX "idx_notifications_active" ON "public"."notifications" USING btree ("is_active");
CREATE INDEX "idx_notifications_deleted_at" ON "public"."notifications" USING btree ("deleted_at") WHERE deleted_at IS NOT NULL;