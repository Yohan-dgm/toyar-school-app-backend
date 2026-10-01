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
 
 Date: 06/10/2025 15:30:00
 */
-- ----------------------------
-- Sequence structure for edu_fb_category_pr_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_category_pr_id_seq";

CREATE SEQUENCE "public"."edu_fb_category_pr_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_category_pr
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_category_pr";

CREATE TABLE "public"."edu_fb_category_pr" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_category_pr_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fb_category_pr (Primary section specific categories)
-- ----------------------------
INSERT INTO "public"."edu_fb_category_pr" VALUES (1, 'Academic Performance', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_pr" VALUES (2, 'Reading and Writing Skills', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_pr" VALUES (3, 'Mathematical Skills', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_pr" VALUES (4, 'Scientific Thinking', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_pr" VALUES (5, 'Social Skills and Teamwork', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_pr" VALUES (6, 'Creative and Artistic Skills', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_pr" VALUES (7, 'Physical Education and Sports', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_pr" VALUES (8, 'Study Habits and Organization', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_pr" VALUES (9, 'Character Development', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_pr" VALUES (10, 'Technology Skills', 't', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table edu_fb_category_pr
-- ----------------------------
ALTER TABLE
    "public"."edu_fb_category_pr"
ADD
    CONSTRAINT "edu_fb_category_pr_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_category_pr_id_seq" OWNED BY "public"."edu_fb_category_pr"."id";

SELECT
    setval(
        '"public"."edu_fb_category_pr_id_seq"',
        10,
        true
    );