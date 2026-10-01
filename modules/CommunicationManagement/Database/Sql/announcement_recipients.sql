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
-- Sequence structure for announcement_recipients_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."announcement_recipients_id_seq";

CREATE SEQUENCE "public"."announcement_recipients_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for announcement_recipients
-- ----------------------------
DROP TABLE IF EXISTS "public"."announcement_recipients";

CREATE TABLE "public"."announcement_recipients" (
    "id" int8 NOT NULL DEFAULT nextval('announcement_recipients_id_seq'::regclass),
    "announcement_id" int8 NOT NULL,
    "user_id" int8 NOT NULL,
    "is_read" bool DEFAULT false,
    "read_at" timestamp(0),
    "is_liked" bool DEFAULT false,
    "liked_at" timestamp(0),
    "view_count" int4 DEFAULT 0,
    "last_viewed_at" timestamp(0),
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Sample Records of announcement_recipients
-- ----------------------------
INSERT INTO "public"."announcement_recipients" VALUES
    (1, 1, 15, 't', '2025-08-11 08:30:00', 't', '2025-08-11 08:35:00', 3, '2025-08-11 09:15:00', '2025-08-11 08:00:05', '2025-08-11 09:15:00'),
    (2, 1, 23, 't', '2025-08-11 09:00:00', 'f', NULL, 1, '2025-08-11 09:00:00', '2025-08-11 08:00:05', '2025-08-11 09:00:00'),
    (3, 1, 34, 'f', NULL, 'f', NULL, 0, NULL, '2025-08-11 08:00:05', '2025-08-11 08:00:05'),
    (4, 2, 15, 't', '2025-08-11 11:00:00', 'f', NULL, 2, '2025-08-11 14:20:00', '2025-08-11 10:30:05', '2025-08-11 14:20:00'),
    (5, 2, 28, 't', '2025-08-11 12:30:00', 't', '2025-08-11 12:35:00', 1, '2025-08-11 12:30:00', '2025-08-11 10:30:05', '2025-08-11 12:35:00'),
    (6, 3, 15, 't', '2025-08-11 15:00:00', 't', '2025-08-11 15:05:00', 1, '2025-08-11 15:00:00', '2025-08-11 14:00:05', '2025-08-11 15:05:00'),
    (7, 3, 23, 'f', NULL, 'f', NULL, 0, NULL, '2025-08-11 14:00:05', '2025-08-11 14:00:05'),
    (8, 4, 15, 't', '2025-08-11 18:05:00', 'f', NULL, 1, '2025-08-11 18:05:00', '2025-08-11 18:00:05', '2025-08-11 18:05:00'),
    (9, 4, 23, 't', '2025-08-11 18:10:00', 'f', NULL, 1, '2025-08-11 18:10:00', '2025-08-11 18:00:05', '2025-08-11 18:10:00'),
    (10, 4, 34, 't', '2025-08-11 18:15:00', 't', '2025-08-11 18:20:00', 2, '2025-08-11 19:00:00', '2025-08-11 18:00:05', '2025-08-11 19:00:00');

-- ----------------------------
-- Primary Key structure for table announcement_recipients
-- ----------------------------
ALTER TABLE "public"."announcement_recipients" 
ADD CONSTRAINT "announcement_recipients_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Unique constraint for announcement-user combination
-- ----------------------------
ALTER TABLE "public"."announcement_recipients" 
ADD CONSTRAINT "announcement_recipients_announcement_user_unique" 
UNIQUE ("announcement_id", "user_id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."announcement_recipients_id_seq" 
OWNED BY "public"."announcement_recipients"."id";

SELECT setval('"public"."announcement_recipients_id_seq"', 10, true);

-- ----------------------------
-- Indexes for table announcement_recipients
-- ----------------------------
CREATE INDEX "idx_announcement_recipients_announcement_id" ON "public"."announcement_recipients" USING btree ("announcement_id");
CREATE INDEX "idx_announcement_recipients_user_id" ON "public"."announcement_recipients" USING btree ("user_id");
CREATE INDEX "idx_announcement_recipients_is_read" ON "public"."announcement_recipients" USING btree ("is_read");
CREATE INDEX "idx_announcement_recipients_is_liked" ON "public"."announcement_recipients" USING btree ("is_liked");
CREATE INDEX "idx_announcement_recipients_created_at" ON "public"."announcement_recipients" USING btree ("created_at" DESC);
CREATE INDEX "idx_announcement_recipients_read_at" ON "public"."announcement_recipients" USING btree ("read_at" DESC) WHERE read_at IS NOT NULL;
CREATE INDEX "idx_announcement_recipients_user_unread" ON "public"."announcement_recipients" USING btree ("user_id", "is_read") WHERE is_read = false;
CREATE INDEX "idx_announcement_recipients_user_liked" ON "public"."announcement_recipients" USING btree ("user_id", "is_liked") WHERE is_liked = true;

-- ----------------------------
-- Foreign key constraints (commented out - add when related tables exist)
-- ----------------------------
-- ALTER TABLE "public"."announcement_recipients" 
-- ADD CONSTRAINT "fk_announcement_recipients_announcement" 
-- FOREIGN KEY ("announcement_id") REFERENCES "public"."announcements" ("id") ON DELETE CASCADE;

-- ALTER TABLE "public"."announcement_recipients" 
-- ADD CONSTRAINT "fk_announcement_recipients_user" 
-- FOREIGN KEY ("user_id") REFERENCES "public"."users" ("id") ON DELETE CASCADE;