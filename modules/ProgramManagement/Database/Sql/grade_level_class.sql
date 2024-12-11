/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 09/12/2024 21:40:04
*/

-- ----------------------------
-- Sequence structure for grade_level_class_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."grade_level_class_id_seq";
CREATE SEQUENCE "public"."grade_level_class_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for grade_level_class
-- ----------------------------
DROP TABLE IF EXISTS "public"."grade_level_class";
CREATE TABLE "public"."grade_level_class" (
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "id" int8 NOT NULL DEFAULT nextval('grade_level_class_id_seq'::regclass),
)
;

-- ----------------------------
-- Records of grade_level_class
-- ----------------------------


-- ----------------------------
-- Primary Key structure for table grade_level_class
-- ----------------------------
ALTER TABLE "public"."grade_level_class" ADD CONSTRAINT "grade_level_class_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."grade_level_class_id_seq"
OWNED BY "public"."grade_level_class"."id";
SELECT setval('"public"."grade_level_class_id_seq"', 1, false);
