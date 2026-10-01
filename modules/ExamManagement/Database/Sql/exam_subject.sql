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
 
 Date: 09/12/2024 11:59:18
 */
-- ----------------------------
-- Sequence structure for exam_subject_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."exam_subject_id_seq";

CREATE SEQUENCE "public"."exam_subject_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for exam_subject
-- ----------------------------
DROP TABLE IF EXISTS "public"."exam_subject";

CREATE TABLE "public"."exam_subject" (
    "id" int8 NOT NULL DEFAULT nextval('exam_subject_id_seq' :: regclass),
    "exam_subject_category_id" int8,
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "exam_subject_code" varchar(255) COLLATE "pg_catalog"."default",
    "exam_subject_components" varchar(255) COLLATE "pg_catalog"."default",
    "has_practical_component" bool,
    "exam_subject_option_code" varchar(255) COLLATE "pg_catalog"."default",
    "exam_subject_fee" numeric(15, 2),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of exam_subject
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table exam_subject
-- ----------------------------
ALTER TABLE
    "public"."exam_subject"
ADD
    CONSTRAINT "exam_subject_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."exam_subject_id_seq" OWNED BY "public"."exam_subject"."id";

SELECT
    setval(
        '"public"."exam_subject_id_seq"',
        1,
        false
    );