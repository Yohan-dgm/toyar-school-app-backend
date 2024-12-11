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
-- Sequence structure for stream_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."stream_id_seq";
CREATE SEQUENCE "public"."stream_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for stream
-- ----------------------------
DROP TABLE IF EXISTS "public"."stream";
CREATE TABLE "public"."stream" (
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "id" int8 NOT NULL DEFAULT nextval('stream_id_seq'::regclass),
);

-- ----------------------------
-- Records of stream
-- ----------------------------
INSERT INTO "public"."stream" VALUES ('Main Stream', NULL, NULL, NULL, NULL, 1);
INSERT INTO "public"."stream" VALUES ('Mathematics Stream', NULL, NULL, NULL, NULL, 2);
INSERT INTO "public"."stream" VALUES ('Biology Stream', NULL, NULL, NULL, NULL, 3);

-- ----------------------------
-- Primary Key structure for table stream
-- ----------------------------
ALTER TABLE "public"."stream" ADD CONSTRAINT "stream_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."stream_id_seq"
OWNED BY "public"."stream"."id";
SELECT setval('"public"."stream_id_seq"', 3, true);
