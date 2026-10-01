/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v5
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 07/01/2025 08:32:39
 */
-- ----------------------------
-- Sequence structure for bank_reconciliation_receipt_voucher_pivot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."bank_reconciliation_receipt_voucher_pivot_id_seq";

CREATE SEQUENCE "public"."bank_reconciliation_receipt_voucher_pivot_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for bank_reconciliation_receipt_voucher_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."bank_reconciliation_receipt_voucher_pivot";

CREATE TABLE "public"."bank_reconciliation_receipt_voucher_pivot" (
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval(
        'bank_reconciliation_receipt_voucher_pivot_id_seq' :: regclass
    ),
    "bank_reconciliation_id" int8,
    "receipt_voucher_id" int8
);

-- ----------------------------
-- Records of bank_reconciliation_receipt_voucher_pivot
-- ----------------------------
-- ----------------------------
-- Primary Key structure for table bank_reconciliation_receipt_voucher_pivot
-- ----------------------------
ALTER TABLE
    "public"."bank_reconciliation_receipt_voucher_pivot"
ADD
    CONSTRAINT "bank_reconciliation_receipt_voucher_pivot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."bank_reconciliation_receipt_voucher_pivot_id_seq" OWNED BY "public"."bank_reconciliation_receipt_voucher_pivot"."id";

SELECT
    setval(
        '"public"."bank_reconciliation_receipt_voucher_pivot_id_seq"',
        1,
        false
    );