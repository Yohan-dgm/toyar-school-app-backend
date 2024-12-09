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

 Date: 09/12/2024 11:59:18
*/

-- ----------------------------
-- Sequence structure for receipt_voucher_status_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."receipt_voucher_status_type_id_seq";
CREATE SEQUENCE "public"."receipt_voucher_status_type_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for receipt_voucher_status_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."receipt_voucher_status_type";
CREATE TABLE "public"."receipt_voucher_status_type" (
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "id" int8 NOT NULL DEFAULT nextval('receipt_voucher_status_type_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "sequential_order" int4
)
;

-- ----------------------------
-- Records of receipt_voucher_status_type
-- ----------------------------
INSERT INTO "public"."receipt_voucher_status_type" VALUES (NULL, NULL, NULL, NULL, 1, 'Settlement Pending', 1);
INSERT INTO "public"."receipt_voucher_status_type" VALUES (NULL, NULL, NULL, NULL, 2, 'Settlement Completed', 2);

-- ----------------------------
-- Primary Key structure for table receipt_voucher_status_type
-- ----------------------------
ALTER TABLE "public"."receipt_voucher_status_type" ADD CONSTRAINT "receipt_voucher_status_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."receipt_voucher_status_type_id_seq"
OWNED BY "public"."receipt_voucher_status_type"."id";
SELECT setval('"public"."receipt_voucher_status_type_id_seq"', 2, true);