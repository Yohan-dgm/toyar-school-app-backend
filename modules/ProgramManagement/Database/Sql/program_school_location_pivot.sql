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
-- Sequence structure for program_school_location_pivot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."program_school_location_pivot_id_seq";
CREATE SEQUENCE "public"."program_school_location_pivot_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- ----------------------------
-- Table structure for program_school_location_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."program_school_location_pivot";
CREATE TABLE "public"."program_school_location_pivot" (
  "program_id" int8,
  "school_location_id" int8,
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "id" int8 NOT NULL DEFAULT nextval('program_school_location_pivot_id_seq'::regclass)
)
;

-- ----------------------------
-- Records of program_school_location_pivot
-- ----------------------------
INSERT INTO "public"."program_school_location_pivot" VALUES (1, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 1);
INSERT INTO "public"."program_school_location_pivot" VALUES (2, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 2);
INSERT INTO "public"."program_school_location_pivot" VALUES (3, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 3);
INSERT INTO "public"."program_school_location_pivot" VALUES (4, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 4);
INSERT INTO "public"."program_school_location_pivot" VALUES (5, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 5);
INSERT INTO "public"."program_school_location_pivot" VALUES (6, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 6);
INSERT INTO "public"."program_school_location_pivot" VALUES (7, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 7);
INSERT INTO "public"."program_school_location_pivot" VALUES (8, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 8);
INSERT INTO "public"."program_school_location_pivot" VALUES (9, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 9);
INSERT INTO "public"."program_school_location_pivot" VALUES (10, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 10);
INSERT INTO "public"."program_school_location_pivot" VALUES (11, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 11);
INSERT INTO "public"."program_school_location_pivot" VALUES (12, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 12);
INSERT INTO "public"."program_school_location_pivot" VALUES (13, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 13);
INSERT INTO "public"."program_school_location_pivot" VALUES (14, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 14);
INSERT INTO "public"."program_school_location_pivot" VALUES (15, 1, NULL, '2024-12-09 10:30:29','2024-12-09 10:30:29', NULL, 15);

-- ----------------------------
-- Primary Key structure for table program_school_location_pivot
-- ----------------------------
ALTER TABLE "public"."program_school_location_pivot" ADD CONSTRAINT "program_school_location_pivot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."program_school_location_pivot_id_seq"
OWNED BY "public"."program_school_location_pivot"."id";
SELECT setval('"public"."program_school_location_pivot_id_seq"', 15, true);
