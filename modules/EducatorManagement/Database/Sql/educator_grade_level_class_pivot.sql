/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v5
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 07/01/2025 08:32:39
 */
-- ----------------------------
-- Sequence structure for educator_grade_level_class_pivot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."educator_grade_level_class_pivot_id_seq";

CREATE SEQUENCE "public"."educator_grade_level_class_pivot_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for educator_grade_level_class_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."educator_grade_level_class_pivot";

CREATE TABLE "public"."educator_grade_level_class_pivot" (
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval(
        'educator_grade_level_class_pivot_id_seq' :: regclass
    ),
    "educator_id" int8,
    "grade_level_class_id" int8
);

-- ----------------------------
-- Records of educator_grade_level_class_pivot
-- ----------------------------
-- ----------------------------
-- Primary Key structure for table educator_grade_level_class_pivot
-- ----------------------------
ALTER TABLE
    "public"."educator_grade_level_class_pivot"
ADD
    CONSTRAINT "educator_grade_level_class_pivot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."educator_grade_level_class_pivot_id_seq" OWNED BY "public"."educator_grade_level_class_pivot"."id";

SELECT
    setval(
        '"public"."educator_grade_level_class_pivot_id_seq"',
        1,
        false
    );