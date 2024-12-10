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

 Date: 06/12/2024 15:57:21
*/
-- ----------------------------
-- Sequence structure for educator_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."educator_id_seq";
CREATE SEQUENCE "public"."educator_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for educator
-- ----------------------------
DROP TABLE IF EXISTS "public"."educator";
CREATE TABLE "public"."educator" (
  "id" int8 NOT NULL DEFAULT nextval('educator_id_seq'::regclass),
  "employee_id" int8 NOT NULL,
  "educator_grade_id" int8,
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(6),
  "updated_at" timestamp(6)
)
;

-- ----------------------------
-- Records of educator
-- ----------------------------
-- ----------------------------
-- Records of educator
-- ----------------------------
INSERT INTO "public"."educator" VALUES (1, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (2, 2, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (3, 3, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (4, 4, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (5, 5, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (6, 9, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (7, 10, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (8, 11, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (9, 12, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (10, 13, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (11, 14, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (12, 15, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (13, 16, 1, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (14, 18, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (15, 19, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (16, 20, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (17, 21, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (18, 22, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (19, 23, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (20, 24, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (21, 25, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."educator" VALUES (22, 26, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table educator
-- ----------------------------
ALTER TABLE "public"."educator" ADD CONSTRAINT "educator_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."educator_id_seq"
OWNED BY "public"."educator"."id";
SELECT setval('"public"."educator_id_seq"', 22, true);

