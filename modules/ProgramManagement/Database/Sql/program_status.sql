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
-- Sequence structure for program_status_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."program_status_id_seq";
CREATE SEQUENCE "public"."program_status_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- ----------------------------
-- Table structure for program_status
-- ----------------------------
DROP TABLE IF EXISTS "public"."program_status";
CREATE TABLE "public"."program_status" (
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "sequential_order" int4,
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "id" int8 NOT NULL DEFAULT nextval('program_status_id_seq'::regclass)
)
;

-- ----------------------------
-- Records of program_status
-- ----------------------------
INSERT INTO "public"."program_status" VALUES ('Active', 1, 1, NULL, '2024-11-12 16:49:46', NULL, 1);
INSERT INTO "public"."program_status" VALUES ('Inactive', 2, 1, NULL, '2024-11-12 16:50:01', NULL, 2);


-- ----------------------------
-- Primary Key structure for table program_status
-- ----------------------------
ALTER TABLE "public"."program_status" ADD CONSTRAINT "program_status_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."program_status_id_seq"
OWNED BY "public"."program_status"."id";
SELECT setval('"public"."program_status_id_seq"', 2, true);
