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
 
 Date: 31/07/2025 13:22:06
 */
-- ----------------------------
-- Sequence structure for edu_fb_category_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_category_id_seq";

CREATE SEQUENCE "public"."edu_fb_category_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_category
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_category";

CREATE TABLE "public"."edu_fb_category" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_category_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fb_category
-- ----------------------------
INSERT INTO "public"."edu_fb_category" VALUES (1, 'Intrapersonal Intelligence', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (2, 'Interpersonal Intelligence', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (3, 'Musical Intelligence', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (4, 'Bodily Kinesthetic Intelligence', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (5, 'Linguistic Intelligence', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (6, 'Mathematical/Logical Intelligence', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (7, 'Existential Intelligence', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (8, 'Spatial Intelligence', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (9, 'Naturalistic Intelligence', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (10, 'Contribution to the School Community', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (11, 'Contribution to Society', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (12, 'Attendance and Punctuality', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category" VALUES (13, 'Life Skills Development', 't', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table edu_fb_category
-- ----------------------------
ALTER TABLE
    "public"."edu_fb_category"
ADD
    CONSTRAINT "edu_fb_category_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_category_id_seq" OWNED BY "public"."edu_fb_category"."id";

SELECT
    setval(
        '"public"."edu_fb_category_id_seq"',
        8,
        true
    );