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

 Date: 10/12/2024 22:11:35
*/


DROP SEQUENCE IF EXISTS "public"."designation_id_seq";
CREATE SEQUENCE "public"."designation_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- ----------------------------
-- Table structure for designation
-- ----------------------------
DROP TABLE IF EXISTS "public"."designation";
CREATE TABLE "public"."designation" (
  "id" int8 NOT NULL DEFAULT nextval('designation_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_by" int8,
  "updated_by" int8
)
;

-- ----------------------------
-- Records of designation
-- ----------------------------
INSERT INTO "public"."designation" VALUES (1, 'Class Teacher', NULL, NULL);
INSERT INTO "public"."designation" VALUES (2, 'Subject Teacher', NULL, NULL);
INSERT INTO "public"."designation" VALUES (5, 'Deputy Chief Operating Officer', NULL, NULL);
INSERT INTO "public"."designation" VALUES (3, 'Head Teacher', NULL, NULL);
INSERT INTO "public"."designation" VALUES (6, 'Managing Director', NULL, NULL);
INSERT INTO "public"."designation" VALUES (4, 'Assistant Teacher', NULL, NULL);
INSERT INTO "public"."designation" VALUES (7, 'Chief Operating Officer', NULL, NULL);
INSERT INTO "public"."designation" VALUES (8, 'Deputy Principal', NULL, NULL);
INSERT INTO "public"."designation" VALUES (9, 'Junior Executive - Administration', NULL, NULL);
INSERT INTO "public"."designation" VALUES (10, 'Basket Ball Coach', NULL, NULL);
INSERT INTO "public"."designation" VALUES (11, 'Swimming Coach', NULL, NULL);
INSERT INTO "public"."designation" VALUES (12, 'Athletic Coach', NULL, NULL);
INSERT INTO "public"."designation" VALUES (13, 'Cricket Coah', NULL, NULL);
INSERT INTO "public"."designation" VALUES (14, 'Pickleball Coach', NULL, NULL);

-- ----------------------------
-- Primary Key structure for table designation
-- ----------------------------
ALTER TABLE "public"."designation" ADD CONSTRAINT "designation_pkey" PRIMARY KEY ("id");

ALTER SEQUENCE "public"."designation_id_seq"
OWNED BY "public"."designation"."id";
SELECT setval('"public"."designation_id_seq"', 14, true);

