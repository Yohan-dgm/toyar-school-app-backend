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
-- Sequence structure for grade_promotion_demotion_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."grade_promotion_demotion_id_seq";

CREATE SEQUENCE "public"."grade_promotion_demotion_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for grade_promotion_demotion
-- ----------------------------
DROP TABLE IF EXISTS "public"."grade_promotion_demotion";

CREATE TABLE "public"."grade_promotion_demotion" (
    "id" int8 NOT NULL DEFAULT nextval('grade_promotion_demotion_id_seq' :: regclass),
    "type" varchar(255) COLLATE "pg_catalog"."default",
    "class_joined_date" date,
    "promotion_or_demotion_grade_level_class_id" int8,
    "is_approved" bool,
    "approved_by" int8,
    "reason" text COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "approved_at" timestamp(0),
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table grade_promotion_demotion
-- ----------------------------
ALTER TABLE
    "public"."grade_promotion_demotion"
ADD
    CONSTRAINT "grade_promotion_demotion_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."grade_promotion_demotion_id_seq" OWNED BY "public"."grade_promotion_demotion"."id";

SELECT
    setval(
        '"public"."grade_promotion_demotion_id_seq"',
        1,
        false
    );