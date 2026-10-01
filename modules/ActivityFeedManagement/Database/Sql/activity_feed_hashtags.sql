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

 Date: 05/08/2025 16:30:00
*/

-- ----------------------------
-- Sequence structure for activity_feed_hashtags_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."activity_feed_hashtags_id_seq";

CREATE SEQUENCE "public"."activity_feed_hashtags_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for activity_feed_hashtags
-- ----------------------------
DROP TABLE IF EXISTS "public"."activity_feed_hashtags";

CREATE TABLE "public"."activity_feed_hashtags" (
    "id" int8 NOT NULL DEFAULT nextval('activity_feed_hashtags_id_seq'::regclass),
    "hashtag" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
    "post_id" int8,
    "post_type" varchar(50) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'activity_feed_post',
    "is_active" bool DEFAULT false,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of activity_feed_hashtags
-- ----------------------------
INSERT INTO "public"."activity_feed_hashtags" VALUES
    (1, 'NewYear', 1, 't', NULL, NULL, '2024-01-15 09:00:00', '2024-01-15 09:00:00'),
    (2, 'Welcome', 1, 't', NULL, NULL, '2024-01-15 09:00:00', '2024-01-15 09:00:00'),
    (3, 'Academic2024', 1, 't', NULL, NULL, '2024-01-15 09:00:00', '2024-01-15 09:00:00'),
    (4, 'SportsDay', 2, 't', NULL, NULL, '2024-01-20 10:30:00', '2024-01-20 10:30:00'),
    (5, 'Competition', 2, 't', NULL, NULL, '2024-01-20 10:30:00', '2024-01-20 10:30:00'),
    (6, 'Fun', 2, 't', NULL, NULL, '2024-01-20 10:30:00', '2024-01-20 10:30:00'),
    (7, 'Science', 3, 't', NULL, NULL, '2024-01-25 14:15:00', '2024-01-25 14:15:00'),
    (8, 'Laboratory', 3, 't', NULL, NULL, '2024-01-25 14:15:00', '2024-01-25 14:15:00'),
    (9, 'Education', 3, 't', NULL, NULL, '2024-01-25 14:15:00', '2024-01-25 14:15:00'),
    (10, 'Mathematics', 4, 't', NULL, NULL, '2024-02-01 11:45:00', '2024-02-01 11:45:00'),
    (11, 'Achievement', 4, 't', NULL, NULL, '2024-02-01 11:45:00', '2024-02-01 11:45:00'),
    (12, 'Pride', 4, 't', NULL, NULL, '2024-02-01 11:45:00', '2024-02-01 11:45:00'),
    (13, 'Health', 5, 't', NULL, NULL, '2024-02-05 08:30:00', '2024-02-05 08:30:00'),
    (14, 'Safety', 5, 't', NULL, NULL, '2024-02-05 08:30:00', '2024-02-05 08:30:00'),
    (15, 'Guidelines', 5, 't', NULL, NULL, '2024-02-05 08:30:00', '2024-02-05 08:30:00');

-- ----------------------------
-- Primary Key structure for table activity_feed_hashtags
-- ----------------------------
ALTER TABLE "public"."activity_feed_hashtags" 
ADD CONSTRAINT "activity_feed_hashtags_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."activity_feed_hashtags_id_seq" 
OWNED BY "public"."activity_feed_hashtags"."id";

SELECT setval('"public"."activity_feed_hashtags_id_seq"', 15, true);

-- ----------------------------
-- Indexes for table activity_feed_hashtags
-- ----------------------------
CREATE INDEX "idx_activity_feed_hashtags_post_id" ON "public"."activity_feed_hashtags" USING btree ("post_id");
CREATE INDEX "idx_activity_feed_hashtags_post_type" ON "public"."activity_feed_hashtags" USING btree ("post_type");
CREATE INDEX "idx_activity_feed_hashtags_hashtag" ON "public"."activity_feed_hashtags" USING btree ("hashtag");