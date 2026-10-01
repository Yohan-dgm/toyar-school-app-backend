/*
 Activity Feed Notification Settings Table - Per post-type enable/disable
 toggle for the School/Student/Class post push notifications.

 Date: 23/09/2026
*/

-- ----------------------------
-- Sequence structure for activity_feed_notification_settings_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."activity_feed_notification_settings_id_seq";

CREATE SEQUENCE "public"."activity_feed_notification_settings_id_seq"
    INCREMENT 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    START 1
    CACHE 1;

-- ----------------------------
-- Table structure for activity_feed_notification_settings
-- ----------------------------
DROP TABLE IF EXISTS "public"."activity_feed_notification_settings";

CREATE TABLE "public"."activity_feed_notification_settings" (
    "id" int8 NOT NULL DEFAULT nextval('activity_feed_notification_settings_id_seq'::regclass),
    "section" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
    "is_enabled" bool NOT NULL DEFAULT true,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table activity_feed_notification_settings
-- ----------------------------
ALTER TABLE "public"."activity_feed_notification_settings"
ADD CONSTRAINT "activity_feed_notification_settings_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Unique constraint for table activity_feed_notification_settings
-- ----------------------------
ALTER TABLE "public"."activity_feed_notification_settings"
ADD CONSTRAINT "unique_activity_feed_notification_section" UNIQUE ("section");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."activity_feed_notification_settings_id_seq"
OWNED BY "public"."activity_feed_notification_settings"."id";

SELECT setval('"public"."activity_feed_notification_settings_id_seq"', 1, false);

-- ----------------------------
-- Default rows: all sections enabled
-- ----------------------------
INSERT INTO "public"."activity_feed_notification_settings" ("section", "is_enabled", "created_at", "updated_at")
VALUES
    ('school_post', true, now(), now()),
    ('student_post', true, now(), now()),
    ('class_post', true, now(), now());
