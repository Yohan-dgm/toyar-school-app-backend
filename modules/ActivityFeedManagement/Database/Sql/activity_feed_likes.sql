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

 Date: 05/08/2025 16:45:00
*/

-- ----------------------------
-- Sequence structure for activity_feed_likes_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."activity_feed_likes_id_seq";

CREATE SEQUENCE "public"."activity_feed_likes_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for activity_feed_likes
-- ----------------------------
DROP TABLE IF EXISTS "public"."activity_feed_likes";

CREATE TABLE "public"."activity_feed_likes" (
    "id" int8 NOT NULL DEFAULT nextval('activity_feed_likes_id_seq'::regclass),
    "post_id" int8 NOT NULL,
    "post_type" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
    "user_id" int8 NOT NULL,
    "is_active" bool DEFAULT false,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of activity_feed_likes
-- ----------------------------
INSERT INTO "public"."activity_feed_likes" VALUES
    (1, 1, 1, 't', NULL, NULL, '2024-01-15 09:30:00', '2024-01-15 09:30:00'),
    (2, 1, 2, 't', NULL, NULL, '2024-01-15 10:15:00', '2024-01-15 10:15:00'),
    (3, 1, 3, 't', NULL, NULL, '2024-01-15 11:00:00', '2024-01-15 11:00:00'),
    (4, 2, 1, 't', NULL, NULL, '2024-01-20 11:00:00', '2024-01-20 11:00:00'),
    (5, 2, 2, 't', NULL, NULL, '2024-01-20 11:30:00', '2024-01-20 11:30:00'),
    (6, 2, 4, 't', NULL, NULL, '2024-01-20 12:00:00', '2024-01-20 12:00:00'),
    (7, 3, 1, 't', NULL, NULL, '2024-01-25 15:00:00', '2024-01-25 15:00:00'),
    (8, 3, 3, 't', NULL, NULL, '2024-01-25 15:30:00', '2024-01-25 15:30:00'),
    (9, 4, 1, 't', NULL, NULL, '2024-02-01 12:00:00', '2024-02-01 12:00:00'),
    (10, 4, 2, 't', NULL, NULL, '2024-02-01 12:30:00', '2024-02-01 12:30:00'),
    (11, 4, 3, 't', NULL, NULL, '2024-02-01 13:00:00', '2024-02-01 13:00:00'),
    (12, 4, 4, 't', NULL, NULL, '2024-02-01 13:30:00', '2024-02-01 13:30:00'),
    (13, 5, 1, 't', NULL, NULL, '2024-02-05 09:00:00', '2024-02-05 09:00:00'),
    (14, 5, 2, 't', NULL, NULL, '2024-02-05 09:30:00', '2024-02-05 09:30:00');

-- ----------------------------
-- Primary Key structure for table activity_feed_likes
-- ----------------------------
ALTER TABLE "public"."activity_feed_likes" 
ADD CONSTRAINT "activity_feed_likes_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Unique constraint for table activity_feed_likes
-- ----------------------------
-- ALTER TABLE "public"."activity_feed_likes" 
-- ADD CONSTRAINT "unique_post_user_like" UNIQUE ("post_id", "user_id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."activity_feed_likes_id_seq" 
OWNED BY "public"."activity_feed_likes"."id";

SELECT setval('"public"."activity_feed_likes_id_seq"', 14, true);

-- ----------------------------
-- Indexes for table activity_feed_likes
-- ----------------------------
CREATE INDEX "idx_activity_feed_likes_post_id" ON "public"."activity_feed_likes" USING btree ("post_id");
CREATE INDEX "idx_activity_feed_likes_post_type" ON "public"."activity_feed_likes" USING btree ("post_type");
CREATE INDEX "idx_activity_feed_likes_user_id" ON "public"."activity_feed_likes" USING btree ("user_id");