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

 Date: 10/12/2024 06:48:33
*/

-- ----------------------------
-- Sequence structure for educator_grade_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."educator_grade_id_seq";
CREATE SEQUENCE "public"."educator_grade_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;
-- ----------------------------
-- Table structure for educator_grade
-- ----------------------------
DROP TABLE IF EXISTS "public"."educator_grade";
CREATE TABLE "public"."educator_grade" (
  "id" int8 NOT NULL DEFAULT nextval('educator_grade_id_seq'::regclass),
   "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6),
  "updated_by" timestamp(6)
)
;

-- ----------------------------
-- Records of educator_grade
-- ----------------------------
INSERT INTO "public"."educator_grade" VALUES (1, 'Teacher - Grade I', NULL, NULL);
INSERT INTO "public"."educator_grade" VALUES (2, 'Teacher - Grade II', NULL, NULL);
INSERT INTO "public"."educator_grade" VALUES (3, 'Teacher - Grade III', NULL, NULL);
INSERT INTO "public"."educator_grade" VALUES (4, 'Teacher - Grade IV', NULL, NULL);

-- ----------------------------
-- Primary Key structure for table educator_grade
-- ----------------------------
ALTER TABLE "public"."educator_grade" ADD CONSTRAINT "educator_grade_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."educator_grade_id_seq"
OWNED BY "public"."educator_grade"."id";
SELECT setval('"public"."educator_grade_id_seq"', 4, true);

