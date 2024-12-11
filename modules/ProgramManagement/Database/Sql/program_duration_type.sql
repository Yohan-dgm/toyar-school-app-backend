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
-- Sequence structure for program_duration_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."program_duration_type_id_seq";
CREATE SEQUENCE "public"."program_duration_type_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for program_duration_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."program_duration_type";
CREATE TABLE "public"."program_duration_type" (
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "id" int8 NOT NULL DEFAULT nextval('program_duration_type_id_seq'::regclass)
);

-- ----------------------------
-- Records of program_duration_type
-- ----------------------------
INSERT INTO "public"."program_duration_type" VALUES ('Specific Duration', NULL, NULL, NULL, NULL, 1);
INSERT INTO "public"."program_duration_type" VALUES ('Recurring Classes', NULL, NULL, NULL, NULL, 2);

-- ----------------------------
-- Primary Key structure for table program_duration_type
-- ----------------------------
ALTER TABLE "public"."program_duration_type" ADD CONSTRAINT "program_duration_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."program_duration_type_id_seq"
OWNED BY "public"."program_duration_type"."id";
SELECT setval('"public"."program_duration_type_id_seq"', 2, true);
