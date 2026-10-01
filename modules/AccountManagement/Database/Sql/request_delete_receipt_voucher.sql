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
 
 Date: 15/12/2024 00:24:45
 */
-- ----------------------------
-- Sequence structure for cash_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."request_delete_receipt_voucher_id_seq";

CREATE SEQUENCE "public"."request_delete_receipt_voucher_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for request_delete_receipt_voucher
-- ----------------------------
DROP TABLE IF EXISTS "public"."request_delete_receipt_voucher";

CREATE TABLE "public"."request_delete_receipt_voucher" (
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(6),
    "updated_at" timestamp(6),
    "id" int8 NOT NULL DEFAULT nextval(
        'request_delete_receipt_voucher_id_seq' :: regclass
    ),
    "delete_reason" varchar(255) COLLATE "pg_catalog"."default",
    "receipt_voucher_id" int8,
    "requested_by" int8,
    "requested_date" timestamp(6)
);

-- ----------------------------
-- Primary Key structure for table request_delete_receipt_voucher
-- ----------------------------
ALTER TABLE
    "public"."request_delete_receipt_voucher"
ADD
    CONSTRAINT "request_delete_receipt_voucher_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."request_delete_receipt_voucher_id_seq" OWNED BY "public"."request_delete_receipt_voucher"."id";

SELECT
    setval(
        '"public"."request_delete_receipt_voucher_id_seq"',
        1,
        false
    );