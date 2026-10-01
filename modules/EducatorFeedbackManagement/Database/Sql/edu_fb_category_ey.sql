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
-- Sequence structure for edu_fb_category_ey_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_category_ey_id_seq";

CREATE SEQUENCE "public"."edu_fb_category_ey_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_category_ey
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_category_ey";

CREATE TABLE "public"."edu_fb_category_ey" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_category_ey_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fb_category_ey (Early Years specific categories)
-- ----------------------------
INSERT INTO "public"."edu_fb_category_ey" VALUES (1, 'Physical Development', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_ey" VALUES (2, 'Social and Emotional Development', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_ey" VALUES (3, 'Language and Communication', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_ey" VALUES (4, 'Cognitive Development', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_ey" VALUES (5, 'Creative Expression', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_ey" VALUES (6, 'Self-Care Skills', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_ey" VALUES (7, 'Play and Exploration', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_ey" VALUES (8, 'Early Literacy Skills', 't', NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_category_ey" VALUES (9, 'Early Numeracy Skills', 't', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table edu_fb_category_ey
-- ----------------------------
ALTER TABLE
    "public"."edu_fb_category_ey"
ADD
    CONSTRAINT "edu_fb_category_ey_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_category_ey_id_seq" OWNED BY "public"."edu_fb_category_ey"."id";

SELECT
    setval(
        '"public"."edu_fb_category_ey_id_seq"',
        9,
        true
    );