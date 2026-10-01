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
-- Sequence structure for notification_recipients_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."notification_recipients_id_seq";

CREATE SEQUENCE "public"."notification_recipients_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for notification_recipients
-- ----------------------------
DROP TABLE IF EXISTS "public"."notification_recipients";

CREATE TABLE "public"."notification_recipients" (
    "id" int8 NOT NULL DEFAULT nextval('notification_recipients_id_seq'::regclass),
    "notification_id" int8 NOT NULL,
    "user_id" int8 NOT NULL,
    "is_read" bool DEFAULT false,
    "read_at" timestamp(0),
    "is_delivered" bool DEFAULT false,
    "delivered_at" timestamp(0),
    "delivery_method" varchar(50) COLLATE "pg_catalog"."default" DEFAULT 'in_app',
    "push_token" varchar(500) COLLATE "pg_catalog"."default",
    "push_sent" bool DEFAULT false,
    "push_sent_at" timestamp(0),
    "email_sent" bool DEFAULT false,
    "email_sent_at" timestamp(0),
    "sms_sent" bool DEFAULT false,
    "sms_sent_at" timestamp(0),
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Sample Records of notification_recipients
-- ----------------------------
INSERT INTO "public"."notification_recipients" VALUES
    (1, 1, 15, 't', '2025-08-11 09:15:00', 't', '2025-08-11 09:00:05', 'in_app', NULL, 'f', NULL, 'f', NULL, 'f', NULL, '2025-08-11 09:00:05', '2025-08-11 09:15:00'),
    (2, 1, 23, 'f', NULL, 't', '2025-08-11 09:00:05', 'in_app', NULL, 'f', NULL, 'f', NULL, 'f', NULL, '2025-08-11 09:00:05', '2025-08-11 09:00:05'),
    (3, 1, 34, 't', '2025-08-11 09:30:00', 't', '2025-08-11 09:00:05', 'in_app', NULL, 'f', NULL, 'f', NULL, 'f', NULL, '2025-08-11 09:00:05', '2025-08-11 09:30:00'),
    (4, 2, 15, 't', '2025-08-11 11:00:00', 't', '2025-08-11 10:30:05', 'in_app', 'ExponentPushToken[abc123]', 't', '2025-08-11 10:30:10', 'f', NULL, 'f', NULL, '2025-08-11 10:30:05', '2025-08-11 11:00:00'),
    (5, 2, 28, 'f', NULL, 't', '2025-08-11 10:30:05', 'in_app', 'ExponentPushToken[def456]', 't', '2025-08-11 10:30:10', 'f', NULL, 'f', NULL, '2025-08-11 10:30:05', '2025-08-11 10:30:05'),
    (6, 3, 15, 't', '2025-08-11 16:00:00', 't', '2025-08-11 15:45:05', 'in_app', 'ExponentPushToken[abc123]', 't', '2025-08-11 15:45:10', 't', '2025-08-11 15:45:15', 't', '2025-08-11 15:45:20', '2025-08-11 15:45:05', '2025-08-11 16:00:00'),
    (7, 3, 23, 't', '2025-08-11 15:50:00', 't', '2025-08-11 15:45:05', 'in_app', NULL, 'f', NULL, 't', '2025-08-11 15:45:15', 'f', NULL, '2025-08-11 15:45:05', '2025-08-11 15:50:00'),
    (8, 5, 45, 'f', NULL, 't', '2025-08-11 14:20:05', 'in_app', 'ExponentPushToken[ghi789]', 't', '2025-08-11 14:20:10', 't', '2025-08-11 14:20:15', 'f', NULL, '2025-08-11 14:20:05', '2025-08-11 14:20:05');

-- ----------------------------
-- Primary Key structure for table notification_recipients
-- ----------------------------
ALTER TABLE "public"."notification_recipients" 
ADD CONSTRAINT "notification_recipients_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Unique constraint for notification-user combination
-- ----------------------------
ALTER TABLE "public"."notification_recipients" 
ADD CONSTRAINT "notification_recipients_notification_user_unique" 
UNIQUE ("notification_id", "user_id");

-- ----------------------------
-- Check constraints
-- ----------------------------
ALTER TABLE "public"."notification_recipients" 
ADD CONSTRAINT "notification_recipients_delivery_method_check" 
CHECK (delivery_method IN ('in_app', 'push', 'email', 'sms', 'all'));

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."notification_recipients_id_seq" 
OWNED BY "public"."notification_recipients"."id";

SELECT setval('"public"."notification_recipients_id_seq"', 8, true);

-- ----------------------------
-- Indexes for table notification_recipients
-- ----------------------------
CREATE INDEX "idx_notification_recipients_notification_id" ON "public"."notification_recipients" USING btree ("notification_id");
CREATE INDEX "idx_notification_recipients_user_id" ON "public"."notification_recipients" USING btree ("user_id");
CREATE INDEX "idx_notification_recipients_is_read" ON "public"."notification_recipients" USING btree ("is_read");
CREATE INDEX "idx_notification_recipients_is_delivered" ON "public"."notification_recipients" USING btree ("is_delivered");
CREATE INDEX "idx_notification_recipients_created_at" ON "public"."notification_recipients" USING btree ("created_at" DESC);
CREATE INDEX "idx_notification_recipients_read_at" ON "public"."notification_recipients" USING btree ("read_at" DESC) WHERE read_at IS NOT NULL;
CREATE INDEX "idx_notification_recipients_user_unread" ON "public"."notification_recipients" USING btree ("user_id", "is_read") WHERE is_read = false;