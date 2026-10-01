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
 
 Date: 26/12/2024 07:43:34
 */
-- ----------------------------
-- Sequence structure for receipt-voucher-delete-attachment_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."receipt-voucher-delete-attachment_id_seq";

CREATE SEQUENCE "public"."receipt-voucher-delete-attachment_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for receipt-voucher-delete-attachment
-- ----------------------------
DROP TABLE IF EXISTS "public"."receipt-voucher-delete-attachment";

CREATE TABLE "public"."receipt-voucher-delete-attachment" (
    "receipt_voucher_id" int8,
    "file_name" text COLLATE "pg_catalog"."default",
    "original_file_name" text COLLATE "pg_catalog"."default",
    "mime_type" text COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval(
        'receipt-voucher-delete-attachment_id_seq' :: regclass
    )
);

-- ----------------------------
-- Primary Key structure for table receipt-voucher-delete-attachment
-- ----------------------------
ALTER TABLE
    "public"."receipt-voucher-delete-attachment"
ADD
    CONSTRAINT "receipt-voucher-delete-attachment_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."receipt-voucher-delete-attachment_id_seq" OWNED BY "public"."receipt-voucher-delete-attachment"."id";

SELECT
    setval(
        '"public"."receipt-voucher-delete-attachment_id_seq"',
        1,
        false
    );