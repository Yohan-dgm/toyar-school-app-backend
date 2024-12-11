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

 Date: 09/12/2024 10:15:12
*/


-- ----------------------------
-- Sequence structure for role_group_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."role_group_id_seq";
CREATE SEQUENCE "public"."role_group_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;
-- ----------------------------
-- Table structure for role_group
-- ----------------------------
DROP TABLE IF EXISTS "public"."role_group";
CREATE TABLE "public"."role_group" (
  "id" int8 NOT NULL DEFAULT nextval('role_group_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
)
;

-- ----------------------------
-- Records of role_group
-- ----------------------------
INSERT INTO "public"."role_group" VALUES (1, 'Academics', NULL, NULL);
INSERT INTO "public"."role_group" VALUES (2, 'Administration', NULL, NULL);
INSERT INTO "public"."role_group" VALUES (3, 'Accounting', NULL, NULL);

-- ----------------------------
-- Primary Key structure for table role_group
-- ----------------------------
ALTER TABLE "public"."role_group" ADD CONSTRAINT "role_group_pkey" PRIMARY KEY ("id");


-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."role_group_id_seq"
OWNED BY "public"."role_group"."id";
SELECT setval('"public"."role_group_id_seq"', 3, true);


