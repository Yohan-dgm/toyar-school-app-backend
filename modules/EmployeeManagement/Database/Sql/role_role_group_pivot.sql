/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v1 
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 06/12/2024 14:05:35
*/
-- ----------------------------
-- Sequence structure for Role_role_group_pivot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."Role_role_group_pivot_id_seq";
CREATE SEQUENCE "public"."Role_role_group_pivot_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for Role_role_group_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."Role_role_group_pivot";
CREATE TABLE "public"."Role_role_group_pivot" (
  "id" int8 NOT NULL DEFAULT nextval('Role_role_group_pivot_id_seq'::regclass),
  "role_id" int8 NOT NULL,
  "role_group_id" int8 NOT NULL
)
;

-- ----------------------------
-- Records of Role_role_group_pivot
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table Role_role_group_pivot
-- ----------------------------
ALTER TABLE "public"."Role_role_group_pivot" ADD CONSTRAINT "Role_role_group_pivot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."Role_role_group_pivot_id_seq"
OWNED BY "public"."Role_role_group_pivot"."id";
SELECT setval('"public"."Role_role_group_pivot_id_seq"', 1, false);
