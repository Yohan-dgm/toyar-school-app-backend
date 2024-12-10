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
-- Sequence structure for curriculum_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."curriculum_type_id_seq";
CREATE SEQUENCE "public"."curriculum_type_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for curriculum_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."curriculum_type";
CREATE TABLE "public"."curriculum_type" (
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "id" int8 NOT NULL DEFAULT nextval('curriculum_type_id_seq'::regclass)
)
;

-- ----------------------------
-- Records of curriculum_type
-- ----------------------------
INSERT INTO "public"."curriculum_type" VALUES ('Cambridge Curriculum', 1, NULL, '2024-11-12 16:32:07', NULL, 1);

-- ----------------------------
-- Primary Key structure for table curriculum_type
-- ----------------------------
ALTER TABLE "public"."curriculum_type" ADD CONSTRAINT "curriculum_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."curriculum_type_id_seq"
OWNED BY "public"."curriculum_type"."id";
SELECT setval('"public"."curriculum_type_id_seq"', 1, true);
