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
-- Sequence structure for program_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."program_type_id_seq";
CREATE SEQUENCE "public"."program_type_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- ----------------------------
-- Table structure for program_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."program_type";
CREATE TABLE "public"."program_type" (
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "id" int8 NOT NULL DEFAULT nextval('program_type_id_seq'::regclass),
)
;

-- ----------------------------
-- Records of program_type
-- ----------------------------
INSERT INTO "public"."program_type" VALUES ('Main Program', 1, NULL, '2024-11-12 16:31:29', NULL, 1);

-- ----------------------------
-- Primary Key structure for table program_type
-- ----------------------------
ALTER TABLE "public"."program_type" ADD CONSTRAINT "program_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."program_type_id_seq"
OWNED BY "public"."program_type"."id";
SELECT setval('"public"."program_type_id_seq"', 1, true);
