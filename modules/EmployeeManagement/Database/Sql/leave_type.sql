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

 Date: 09/12/2024 11:41:05
*/
-- ----------------------------
-- Sequence structure for leave_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."leave_type_id_seq";
CREATE SEQUENCE "public"."leave_type_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- ----------------------------
-- Table structure for leave_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."leave_type";
CREATE TABLE "public"."leave_type" (
  "id" int8 NOT NULL DEFAULT nextval('leave_type_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of leave_type
-- ----------------------------
INSERT INTO "public"."leave_type" VALUES (1, 'Annual Leave', NULL, NULL);
INSERT INTO "public"."leave_type" VALUES (2, 'Medical Leave', NULL, NULL);
INSERT INTO "public"."leave_type" VALUES (3, 'Maternity Leave', NULL, NULL);

-- ----------------------------
-- Primary Key structure for table leave_type
-- ----------------------------
ALTER TABLE "public"."leave_type" ADD CONSTRAINT "leave_type_pkey" PRIMARY KEY ("id");


-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."leave_type_id_seq"
OWNED BY "public"."leave_type"."id";
SELECT setval('"public"."leave_type_id_seq"', 3, true);

