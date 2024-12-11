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

 Date: 10/12/2024 06:25:55
*/
-- ----------------------------
-- Sequence structure for student_admission_source_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_admission_source_id_seq";
CREATE SEQUENCE "public"."student_admission_source_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for student_admission_source
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_admission_source";
CREATE TABLE "public"."student_admission_source" (
  "id" int8 NOT NULL DEFAULT nextval('student_admission_source_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of student_admission_source
-- ----------------------------
INSERT INTO "public"."student_admission_source" VALUES (1, 'Lakshitha sirs contact', NULL, NULL);
INSERT INTO "public"."student_admission_source" VALUES (2, 'NBK student', NULL, NULL);
INSERT INTO "public"."student_admission_source" VALUES (3, 'Socail media campaign', NULL, NULL);
INSERT INTO "public"."student_admission_source" VALUES (4, 'Old student of NBK', NULL, NULL);
INSERT INTO "public"."student_admission_source" VALUES (5, 'Word of Mouth', NULL, NULL);
INSERT INTO "public"."student_admission_source" VALUES (6, 'Ruwan sirs contact', NULL, NULL);
INSERT INTO "public"."student_admission_source" VALUES (7, 'CRM', NULL, NULL);
INSERT INTO "public"."student_admission_source" VALUES (8, 'SUNICO', NULL, NULL);
INSERT INTO "public"."student_admission_source" VALUES (9, 'Neighbourhood', NULL, NULL);
INSERT INTO "public"."student_admission_source" VALUES (10, 'Other', NULL, NULL);
INSERT INTO "public"."student_admission_source" VALUES (11, 'Sibling of NBV Student', NULL, NULL);


-- ----------------------------
-- Primary Key structure for table student_admission_source
-- ----------------------------
ALTER TABLE "public"."student_admission_source" ADD CONSTRAINT "student_admission_source_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_admission_source_id_seq"
OWNED BY "public"."student_admission_source"."id";
SELECT setval('"public"."student_admission_source_id_seq"', 11, true);
