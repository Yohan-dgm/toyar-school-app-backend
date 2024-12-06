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
-- Table structure for user_user_type_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_user_type_pivot";
CREATE TABLE "public"."user_user_type_pivot" (
  "id" int8 NOT NULL DEFAULT nextval('user_user_type_pivot_seqs'::regclass),
  "user_id" int8 NOT NULL,
  "user_type_id" int8 NOT NULL
)
;

-- ----------------------------
-- Records of user_user_type_pivot
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table user_user_type_pivot
-- ----------------------------
ALTER TABLE "public"."user_user_type_pivot" ADD CONSTRAINT "user_user_type_pivot_pkey" PRIMARY KEY ("id");
