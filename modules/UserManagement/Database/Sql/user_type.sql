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
-- Sequence structure for user_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_type_id_seq";
CREATE SEQUENCE "public"."user_type_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for user_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_type";
CREATE TABLE "public"."user_type" (
  "id" int8  NOT NULL  DEFAULT nextval('user_type_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default" ,
   "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
)
;

-- ----------------------------
-- Records of user_type
-- ----------------------------
INSERT INTO "public"."user_type" VALUES (1, 'Administrator', NULL, NULL);
INSERT INTO "public"."user_type" VALUES (2, 'Student', NULL, NULL);
INSERT INTO "public"."user_type" VALUES (3, 'Educator', NULL, NULL);
INSERT INTO "public"."user_type" VALUES (4, 'Parent', NULL, NULL);
INSERT INTO "public"."user_type" VALUES (5, 'Admin', NULL, NULL);
INSERT INTO "public"."user_type" VALUES (6, 'Management', NULL, NULL);

-- ----------------------------
-- Primary Key structure for table user_type
-- ----------------------------
ALTER TABLE "public"."user_type" ADD CONSTRAINT "user_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_type_id_seq"
OWNED BY "public"."user_type"."id";
SELECT setval('"public"."user_type_id_seq"', 6, true);
