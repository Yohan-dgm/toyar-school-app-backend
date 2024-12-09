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

 Date: 09/12/2024 09:41:15
*/
-- ----------------------------
-- Sequence structure for program_requirement_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."program_requirement_id_seq";
CREATE SEQUENCE "public"."program_requirement_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- ----------------------------
-- Table structure for program_requirement
-- ----------------------------
DROP TABLE IF EXISTS "public"."program_requirement";
CREATE TABLE "public"."program_requirement" (
  "title" varchar(255) COLLATE "pg_catalog"."default",
  "description" text COLLATE "pg_catalog"."default",
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "id" int8 NOT NULL DEFAULT nextval('program_requirement_id_seq'::regclass)
)
;

-- ----------------------------
-- Records of program
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table program_requirement
-- ----------------------------
ALTER TABLE "public"."program_requirement" ADD CONSTRAINT "program_requirement_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."program_requirement_id_seq"
OWNED BY "public"."program_requirement"."id";
SELECT setval('"public"."program_requirement_id_seq"', 1, false);
