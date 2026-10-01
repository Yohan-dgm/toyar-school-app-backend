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
-- Sequence structure for edu_fb_category_sc_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_category_sc_id_seq";

CREATE SEQUENCE "public"."edu_fb_category_sc_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_category_sc
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_category_sc";

CREATE TABLE "public"."edu_fb_category_sc" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_category_sc_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fb_category_sc (Secondary section specific categories)
-- ----------------------------
INSERT INTO "public"."edu_fb_category_sc" VALUES (1, 'Subject Mastery', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_sc" VALUES (2, 'Critical Thinking and Analysis', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_sc" VALUES (3, 'Research and Investigation Skills', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_sc" VALUES (4, 'Communication and Presentation', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_sc" VALUES (5, 'Leadership and Initiative', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_sc" VALUES (6, 'Independent Learning', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_sc" VALUES (7, 'Career Preparation', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_sc" VALUES (8, 'Digital Literacy', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_sc" VALUES (9, 'Global Citizenship', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_sc" VALUES (10, 'Exam Preparation and Performance', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_sc" VALUES (11, 'University and Career Readiness', 't', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table edu_fb_category_sc
-- ----------------------------
ALTER TABLE
    "public"."edu_fb_category_sc"
ADD
    CONSTRAINT "edu_fb_category_sc_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_category_sc_id_seq" OWNED BY "public"."edu_fb_category_sc"."id";

SELECT
    setval(
        '"public"."edu_fb_category_sc_id_seq"',
        11,
        true
    );