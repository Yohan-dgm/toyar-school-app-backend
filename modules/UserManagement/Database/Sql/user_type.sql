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

 Date: 06/12/2024 12:53:24
*/


-- ----------------------------
-- Table structure for user_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_type";
CREATE TABLE "public"."user_type" (
  "id" int8 NOT NULL DEFAULT nextval('user_type_seqs'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL
)
;

-- ----------------------------
-- Records of user_type
-- ----------------------------
INSERT INTO "public"."user_type" VALUES (1, 'Administrator');
INSERT INTO "public"."user_type" VALUES (2, 'Student');
INSERT INTO "public"."user_type" VALUES (3, 'Educator');
INSERT INTO "public"."user_type" VALUES (4, 'Parent');
INSERT INTO "public"."user_type" VALUES (5, 'intern');
INSERT INTO "public"."user_type" VALUES (6, 'Coach');
INSERT INTO "public"."user_type" VALUES (7, 'genaral');
