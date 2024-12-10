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
-- Sequence structure for program_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."program_id_seq";
CREATE SEQUENCE "public"."program_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for program
-- ----------------------------
DROP TABLE IF EXISTS "public"."program";
CREATE TABLE "public"."program" (
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "duration" int4,
  "program_code" varchar(255) COLLATE "pg_catalog"."default",
  "program_type_id" int8,
  "curriculum_type_id" int8,
  "grade_level_id" int8,
  "program_duration_type_id" int8,
  "program_status_id" int8,
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "id" int8 NOT NULL DEFAULT nextval('program_id_seq'::regclass)
)
;

-- ----------------------------
-- Records of program
-- ----------------------------
INSERT INTO "public"."program" VALUES ('Grade 10 - Main Program', 12, 'G10-M', 1, 1, 10, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 10);
INSERT INTO "public"."program" VALUES ('Grade 11 - Main Program', 12, 'G11-M', 1, 1, 11, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 11);
INSERT INTO "public"."program" VALUES ('Grade 12 - Main Program', 12, 'G12-M', 1, 1, 12, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 12);
INSERT INTO "public"."program" VALUES ('Grade 2 - Main Program', 12, 'G2-M', 1, 1, 2, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 2);
INSERT INTO "public"."program" VALUES ('Grade 3 - Main Program', 12, 'G3-M', 1, 1, 3, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 3);
INSERT INTO "public"."program" VALUES ('Grade 4 - Main Program', 12, 'G4-M', 1, 1, 4, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 4);
INSERT INTO "public"."program" VALUES ('Grade 5 - Main Program', 12, 'G5-M', 1, 1, 5, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 5);
INSERT INTO "public"."program" VALUES ('Grade 6 - Main Program', 12, 'G6-M', 1, 1, 6, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 6);
INSERT INTO "public"."program" VALUES ('Grade 7 - Main Program', 12, 'G7-M', 1, 1, 7, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 7);
INSERT INTO "public"."program" VALUES ('Grade 8 - Main Program', 12, 'G8-M', 1, 1, 8, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 8);
INSERT INTO "public"."program" VALUES ('Grade 9 - Main Program', 12, 'G9-M', 1, 1, 9, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 9);
INSERT INTO "public"."program" VALUES ('Grade 1 - Main Program', 12, 'G1-M', 1, 1, 1, 1, 1, 1, NULL, '2024-11-12 16:50:27', NULL, 1);
INSERT INTO "public"."program" VALUES ('Early Year 1 - Main Program', 12, 'EY-1-M', 1, 1, 13, 1, 1, 1, NULL, '2024-11-27 02:55:24', NULL, 13);
INSERT INTO "public"."program" VALUES ('Early Year 2 - Main Program', 12, 'EY-2-M', 1, 1, 14, 1, 1, 1, NULL, '2024-11-27 02:56:08', NULL, 14);
INSERT INTO "public"."program" VALUES ('Early Year 3 - Main Program', 12, 'EY-3-M', 1, 1, 15, 1, 1, 1, NULL, '2024-11-27 02:56:48', NULL, 15);

-- ----------------------------
-- Primary Key structure for table program
-- ----------------------------
ALTER TABLE "public"."program" ADD CONSTRAINT "program_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."program_id_seq"
OWNED BY "public"."program"."id";
SELECT setval('"public"."program_id_seq"', 15, true);
