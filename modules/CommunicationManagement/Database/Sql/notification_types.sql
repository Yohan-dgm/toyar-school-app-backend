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
-- Sequence structure for notification_types_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."notification_types_id_seq";

CREATE SEQUENCE "public"."notification_types_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for notification_types
-- ----------------------------
DROP TABLE IF EXISTS "public"."notification_types";

CREATE TABLE "public"."notification_types" (
    "id" int8 NOT NULL DEFAULT nextval('notification_types_id_seq'::regclass),
    "name" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
    "slug" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
    "description" text COLLATE "pg_catalog"."default",
    "icon" varchar(50) COLLATE "pg_catalog"."default",
    "color" varchar(20) COLLATE "pg_catalog"."default",
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of notification_types
-- ----------------------------
INSERT INTO "public"."notification_types" VALUES
    (1, 'System', 'system', 'System-generated notifications and alerts', 'cog', '#6b7280', 't', 1, NULL, '2025-08-11 16:00:00', '2025-08-11 16:00:00'),
    (2, 'Announcement', 'announcement', 'General announcements and notices', 'megaphone', '#3b82f6', 't', 1, NULL, '2025-08-11 16:00:00', '2025-08-11 16:00:00'),
    (3, 'Academic', 'academic', 'Academic-related notifications (grades, assignments, etc.)', 'book-open', '#10b981', 't', 1, NULL, '2025-08-11 16:00:00', '2025-08-11 16:00:00'),
    (4, 'Event', 'event', 'Event reminders and updates', 'calendar', '#f59e0b', 't', 1, NULL, '2025-08-11 16:00:00', '2025-08-11 16:00:00'),
    (5, 'Alert', 'alert', 'Important alerts and urgent messages', 'exclamation-triangle', '#ef4444', 't', 1, NULL, '2025-08-11 16:00:00', '2025-08-11 16:00:00'),
    (6, 'Attendance', 'attendance', 'Attendance-related notifications', 'user-check', '#8b5cf6', 't', 1, NULL, '2025-08-11 16:00:00', '2025-08-11 16:00:00'),
    (7, 'Financial', 'financial', 'Bills, payments, and financial notices', 'credit-card', '#06b6d4', 't', 1, NULL, '2025-08-11 16:00:00', '2025-08-11 16:00:00'),
    (8, 'Social', 'social', 'Social feed and activity notifications', 'users', '#ec4899', 't', 1, NULL, '2025-08-11 16:00:00', '2025-08-11 16:00:00');

-- ----------------------------
-- Primary Key structure for table notification_types
-- ----------------------------
ALTER TABLE "public"."notification_types" 
ADD CONSTRAINT "notification_types_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Unique constraint for slug
-- ----------------------------
ALTER TABLE "public"."notification_types" 
ADD CONSTRAINT "notification_types_slug_unique" UNIQUE ("slug");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."notification_types_id_seq" 
OWNED BY "public"."notification_types"."id";

SELECT setval('"public"."notification_types_id_seq"', 8, true);

-- ----------------------------
-- Indexes for table notification_types
-- ----------------------------
CREATE INDEX "idx_notification_types_slug" ON "public"."notification_types" USING btree ("slug");
CREATE INDEX "idx_notification_types_is_active" ON "public"."notification_types" USING btree ("is_active");