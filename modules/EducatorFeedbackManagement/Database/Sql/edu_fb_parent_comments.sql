/*
 Navicat Premium Data Transfer

 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v1
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 14/10/2025
*/

-- ----------------------------
-- Sequence structure for edu_fb_parent_comments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_parent_comments_id_seq";

CREATE SEQUENCE "public"."edu_fb_parent_comments_id_seq"
    INCREMENT 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    START 1
    CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_parent_comments
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_parent_comments";

CREATE TABLE "public"."edu_fb_parent_comments" (
    "id" bigint NOT NULL DEFAULT nextval('edu_fb_parent_comments_id_seq'::regclass),
    "edu_fb_id" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
    "comment" text COLLATE "pg_catalog"."default" NOT NULL,
    "created_by" bigint NOT NULL,
    "updated_by" bigint,
    "is_active" boolean DEFAULT true,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "edited_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table edu_fb_parent_comments
-- ----------------------------
ALTER TABLE "public"."edu_fb_parent_comments"
    ADD CONSTRAINT "edu_fb_parent_comments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Key structure for table edu_fb_parent_comments
-- ----------------------------
ALTER TABLE "public"."edu_fb_parent_comments"
    ADD CONSTRAINT "edu_fb_parent_comments_edu_fb_id_fkey" FOREIGN KEY ("edu_fb_id") REFERENCES "public"."educator_feedbacks" ("id") ON DELETE CASCADE;

ALTER TABLE "public"."edu_fb_parent_comments"
    ADD CONSTRAINT "edu_fb_parent_comments_created_by_fkey" FOREIGN KEY ("created_by") REFERENCES "public"."user" ("id") ON DELETE CASCADE;

ALTER TABLE "public"."edu_fb_parent_comments"
    ADD CONSTRAINT "edu_fb_parent_comments_updated_by_fkey" FOREIGN KEY ("updated_by") REFERENCES "public"."user" ("id") ON DELETE SET NULL;

-- ----------------------------
-- Indexes for better query performance
-- ----------------------------
CREATE INDEX "edu_fb_parent_comments_edu_fb_id_index" ON "public"."edu_fb_parent_comments" ("edu_fb_id");
CREATE INDEX "edu_fb_parent_comments_created_by_index" ON "public"."edu_fb_parent_comments" ("created_by");
CREATE INDEX "edu_fb_parent_comments_created_at_index" ON "public"."edu_fb_parent_comments" ("created_at");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_parent_comments_id_seq" OWNED BY "public"."edu_fb_parent_comments"."id";

-- ----------------------------
-- Initialize sequence value
-- ----------------------------
SELECT setval('"public"."edu_fb_parent_comments_id_seq"', 1, false);
