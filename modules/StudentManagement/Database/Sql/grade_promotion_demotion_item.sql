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
-- Sequence structure for grade_promotion_demotion_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."grade_promotion_demotion_item_id_seq";

CREATE SEQUENCE "public"."grade_promotion_demotion_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for grade_promotion_demotion_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."grade_promotion_demotion_item";

CREATE TABLE "public"."grade_promotion_demotion_item" (
    "id" int8 NOT NULL DEFAULT nextval(
        'grade_promotion_demotion_item_id_seq' :: regclass
    ),
    "student_id" int8,
    "grade_promotion_demotion_id" int8,
    "current_grade_level_class_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table grade_promotion_demotion_item
-- ----------------------------
ALTER TABLE
    "public"."grade_promotion_demotion_item"
ADD
    CONSTRAINT "grade_promotion_demotion_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."grade_promotion_demotion_item_id_seq" OWNED BY "public"."grade_promotion_demotion_item"."id";

SELECT
    setval(
        '"public"."grade_promotion_demotion_item_id_seq"',
        1,
        false
    );